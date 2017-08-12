<?php

namespace App\Http\Controllers;

use App\Message as Message;
use App\CmSms;
use Illuminate\Http\Request;
use App\Http\Requests;

class SendSmsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Send Sms Controller
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
        $input = $request->input('message');
        //firstOrCreate prevents duplicate inserts
        if (!Message::firstOrCreate(array(
            'from'      => $input['from'],
            'to'        => $input['to'],
            'message'   => $input['content']
        ))) {
            abort(500, "Saving failed.");
        }
        $response = CmSms::sendMessage($input['from'],$input['to'],$input['content']);
        if(strpos($response, 'ERROR')) {
            abort(422, $response);
        }
        return array('message_sent' => true);
    }

}
