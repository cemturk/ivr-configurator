<?php namespace App\Http\Controllers;

use App\CallLogs as CallLogs;
use App\Calls as Calls;

class CallLogsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Outbox Controller
    |--------------------------------------------------------------------------
    |
    | This controller interacts with Outbox view
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
     * Send all calls to the view.
     *
     * @return Response
     */
    public function index()
    {
        return Calls::get();
    }

    public function show($id)
    {
        return CallLogs::where('call-id', $id)->get();
    }
}
