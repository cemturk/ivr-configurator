<?php namespace App\Http\Controllers;

use App\CallLogs as CallLogs;
use App\Calls as Calls;
use App\Instruction as Instructions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CmController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Cm Controller
    |--------------------------------------------------------------------------
    |
    | This controller interacts with Voice API
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return json string
     */
    public function callback(Request $request)
    {

        $call_id = $request->input('call-id');
        $req = json_decode($request->getContent(), true);
        $last_event = null;
        //determine if multiple events received
        if (array_key_exists('type', $req)) { //single event
            $last_event = $req;
            $this->save_event($last_event);
        } else {
            foreach ($req as $single_event) {
                $last_event = $single_event;
                $this->save_event($single_event);
            }
        }
        $type = $last_event['type'];
        $previous_instruction_id = array_key_exists('instruction-id', $last_event) ? $last_event['instruction-id'] : 'treeRoot'; //for new calls ins id is treeRoot
        if ($type != "disconnected" && $type != "exception") {
            $instructions = Instructions::where('parentCode', $previous_instruction_id)->get();
            if (count($instructions) == 1 && $instructions[0]['type'] != "dtmfr") { //if there are more than 1 sub instructions they are dtmf routing options
                return $this->save_instruction($instructions[0]['options'], $call_id);
            } else {
                //apply dtmf route logic here
                $digits = $last_event['digits'];
                for ($i = 0; $i < count($instructions); $i++) {
                    $opts = $instructions[$i]['options'];
                    $options = json_decode($opts);
                    if ($digits == $options->value) {
                        $this->save_instruction($instructions[$i]['options'], $call_id); //log backend dtmf route instruction
                        $instruction = Instructions::where('parentCode', $instructions[$i]['code'])->get(['options'])->first(); //get ins directly instead of array
                        return $this->save_instruction($instruction['options'], $call_id);
                    }
                }
                //at this point digits didnt match any dtmf route value so lets repeat the previous dtmf instruction again
                //normally this should be prevented by setting regex to only match route values
                $instruction = Instructions::where('code', $last_event['instruction-id'])->get()->first();
                return $this->save_instruction($instruction['options'], $call_id);
            }
        }
    }


    /**
     * @param $event
     */
    public function save_event($event)
    {
        $details = '';
        $type = $event['type'];
        //save call
        if ($type == 'new-call' && !Calls::firstOrCreate(array(
                'call-id' => $event['call-id'],
                'from' => $event['caller'],
                'to' => $event['called']
            ))) {
            abort(500, "Saving call failed.");
        }
        switch ($type) {
            case 'new-call':
                $details = 'direction : ' . $event['direction'];
                break;
            case 'dtmf':
                $details = 'digits : ' . $event['digits'];
                break;
            case 'recorded':
                $details = 'file-name : ' . $event['file-name'];
                break;
            case 'exception':
                $details = 'code : ' . $event['code'];
                $details .= ' title : ' . $event['title'];
                $details .= ' message : ' . $event['message'];
                break;
        }
        if (!CallLogs::Create(Array(
            'call-id' => $event['call-id'],
            'instruction-id' => $type == "new-call" ? "" : $event['instruction-id'],
            'event' => $event['type'],
            'details' => $details
        ))) {
            abort(500, "Saving call logs failed.");
        }
    }

    /**
     * @param $instruction
     * @param $call_id
     * @return string
     */
    public function save_instruction($instruction, $call_id)
    {
        //clear json from line ends
        $instruction = str_replace('\n', '', $instruction);
        $instruction = str_replace('\r', '', $instruction);
        $ins = json_decode($instruction, true);
        $ins['call-id'] = $call_id; //add call id to the instruction
        $details = '';
        switch ($ins['type']) {
            case 'record':
            case 'play':
            case 'get-dtmf':
                $details = 'prompt : ' . $ins['prompt'];
                break;
            case 'spell':
                $details = 'code : ' . $ins['code'];
                break;
            case 'dtmfr':
                $details = 'matched value : ' . $ins['value'];
                break;
        }

        if (!CallLogs::Create(Array(
            'call-id' => $call_id,
            'instruction-id' => $ins['instruction-id'],
            'event' => $ins['type'],
            'details' => $details
        ))) {
            abort(500, "Saving call logs failed.");
        }
        return json_encode($ins);
    }

    public function store(Request $request)

    {
        Log::info('received store callback');
        return json_encode($request);
    }

    /**
     * Send all calls to the view.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // return Calls::all();
    }

}
