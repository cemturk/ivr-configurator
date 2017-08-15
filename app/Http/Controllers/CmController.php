<?php namespace App\Http\Controllers;

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

    public function callback(Request $request)
    {
        $type = $request->input('type');
        $insid = $request->input('instruction-id');
        $callid = $request->input('call-id');
        if ($type == "new-call") {
            $instruction = Instructions::where('parentCode', 'treeRoot')->get(['options'])->first(); //get single ins
            return $this->insert_callid($instruction['options'], $callid);
        } else if ($type != "disconnected") {
            $instructions = Instructions::where('parentCode', $insid)->get();
            if (count($instructions) == 1) {
                return $this->insert_callid($instructions[0]['options'], $callid);
            } else { //apply dtmf logic
                $digits = $request->input('digits');
                for ($i = 0; $i < count($instructions); $i++) {
                    $opts = $instructions[$i]['options']; //json_decode($instructions[$i]['options']);
                    $options = json_decode($opts);
                    // return 'f' . $options->value . 'o' . $instructions[$i]['code'];
                    if ($digits == $options->value) {
                        $instruction = Instructions::where('parentCode', $instructions[$i]['code'])->get(['options'])->first(); //get single ins
                        return $this->insert_callid($instruction['options'], $callid);
                    }
                }
            }
        }
    }

    public function insert_callid($instruction, $callid)
    {
        //clear json from line ends
        $instruction = str_replace('\n', ',', $instruction);
        $instruction = str_replace('dtmf', 'get-dtmf', $instruction);
        $instruction = str_replace('\r', '', $instruction);
        $instruction = str_replace('endcall', 'disconnect', $instruction);
        $ins_json = json_decode($instruction, true);
        $ins_json['call-id'] = $callid;
        return json_encode($ins_json);
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
