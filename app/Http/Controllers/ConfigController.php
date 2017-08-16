<?php

namespace App\Http\Controllers;

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
    | This controller interacts with IVR Configurator view
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
     * Store configuration and send it
     *
     * @return response
     */
    public function store(Request $request)
    {
        $input = $request->input('config');
        //save config graph xml
        if (!Config::where('id', $input['id'])
            ->update(['xml' => $input['xml']])) {
            abort(500, "Saving failed.");
        }
        //wipe old instructions and replace them with new ones
        Instructions::where('set_id', $input['id'])
            ->delete();
        for ($i = 0; $i < count($input['instructions']); $i++) {
            $ins = $input['instructions'][$i];
            $set_id = $input['id'];
            //firstOrCreate prevents duplicate inserts
            if (!Instructions::firstOrCreate(array(
                'code' => $ins['id'],
                'type' => $ins['type'],
                'options' => str_replace('_', '-', json_encode($ins['options'])), //convert js object names to match cm api
                'parentCode' => $ins['root'],
                'isRoot' => $ins['isRoot'],
                'set_id' => $set_id
            ))) {
                abort(500, "Saving instruction " . $ins['id'] . " failed.");
            }
        }
        return array('configuration_saved' . $input['id'] => true);
    }

    //send configuration to view
    public function index(Request $request)
    {
        $id = $request->input('confId');
        return Config::find($id);
    }

}
