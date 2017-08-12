<?php namespace App\Http\Controllers;
use App\Message as Message;
class OutboxController extends Controller {

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
	 * Send all messages to the outbox view.
	 *
	 * @return Response
	 */
	public function index()
	{
        return Message::all();
	}

}
