<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Instruction as Instructions;
use App\InstructionSets as Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Config Controller
    |--------------------------------------------------------------------------
    |
    | This controller interacts with Send Message view, stores and send messages using CM Telecom Gateway
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
     * Create a message and send it
     *
     * @return response
     */
    public function store(Request $request)
    {
        $input = $request->input('config');
        //save config xml
        if (!Config::where('id', $input['id'])
            ->update(['xml' => $input['xml']])) {
            abort(500, "Saving failed.");
        }
        //update instructions

        Instructions::where('set_id', $input['id'])
            ->delete();
        for ($i = 0; $i < count($input['instructions']); $i++) {
            $ins = $input['instructions'][$i];
            $set_id = $input['id'];
            //firstOrCreate prevents duplicate inserts
            if (!Instructions::firstOrCreate(array(
                'code' => $ins['id'],
                'type' => $ins['type'],
                'options' => json_encode($ins['options']),
                'parentCode' => $ins['root'],
                'isRoot' => $ins['isRoot'],
                'set_id' => $set_id
            ))) {
                abort(500, "Saving instruction " . $ins['id'] . " failed.");
            }
        }
//        $response = Cm::sendMessage($input['from'],$input['to'],$input['content']);
//        if(strpos($response, 'ERROR')) {
//            abort(422, $response);
//        }
        return array('configuration_saved' . $input['id'] => true);
    }

    public function index(Request $request)
    {
        $id = $request->input('confId');
        return Config::find($id);
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function show()
    {
        //return view('welcome');
    }
}
