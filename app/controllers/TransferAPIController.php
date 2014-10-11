<?php

class TransferAPIController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /transferapis
	 *
	 * @return Response
	 */
	public function index()
	{
		$user=User::find(ResourceServer::getOwnerId());
		$incomingTransfers=$user->incomingTransfers()->where('confirmed','=',0)->get();
		$outgoingTransfers=$user->outgoingTransfers()->take(5)->get();
		return Response::json($incomingTransfers);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /transferapis/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /transferapis
	 *
	 * @return Response
	 */
	public function store()
	{
		$author=User::find(ResourceServer::getOwnerId());
		$max=$author->credits;
		$input=Input::all();
		$validator=Validator::make($input,array(
			'recipient'=>'required',
			'recipient.addressee'=>'required',
			'credits'=>'integer|between:0,'.$max,
		));
		$validator->sometimes('recipient.email','required|email', function($input){
		    return !Input::has('recipient.phoneNumber');
		});
		$validator->sometimes('recipient.phoneNumber','required|numeric',function($input){
			return !Input::has('recipient.email');
		});
		if($validator->fails()){
			return Response::json(array('error',$input,$validator->messages()->toArray()));
		}
		$email=(Input::has('recipient.email') ? $input['recipient']['email']: '');
		$phoneNumber=(Input::has('recipient.phoneNumber')? $input['recipient']['phoneNumber']:'');
		$name=$input['recipient']['addressee'];
		$addresses=Input::has('addresses')?$input['addresses']:null;
		$credits=$input['credits'];
		$user=User::where('email','=',$email)->where('active','=','1')->first();
		if(!isset($user->id)){
			$user=new User;
			$user->email=$email;
			$user->phoneNumber=$phoneNumber;
			$user->splitFullName($name);
			$password=str_random(6);
			$user->password=Hash::make($password);
			$code=str_random(10);
			$user->code=$code;
			$user->active=0;
			$user->save();
			$user_id=DB::connection('mysql')->getPdo()->lastInsertId();
		}
		else{
			$user_id=$user->id;
			$password=null;
			$code=null;
		}
		if($addresses){
			$address_ids=Input::get('addresses');
			$addresses=Addresses::find($address_ids);
			foreach($addresses as $address){
				$address->copyTo($user_id);
				}
		}
		if($credits>0){
			$transfer=new Transfers;
			$transfer->recipient_id=$user_id;
			$transfer->giver_id=$author->id;
			$transfer->credits=$credits;
			$transfer->save();
			$author->credits -= $credits;
			$author->save();
		}else{
			$credits=null;
			$transfer=null;
		}
		if($email){
			$mandrill=new Mandrill(Config::get('mandrill.api_key'));
			$html=View::make('emails.auth.share-activate')->with(array(
				'link'=>URL::route('account-registered',$code),
				'user'=>$user,
				'credits' =>$credits,
		        'addresses'=>$addresses,
		        'password'=>$password,
		        'auth'=>$author,
	        ));
			$html=$html->render();
			 $message = array(
		        'html' => $html,
		        'text' => $html,
		        'subject' => 'account activation',
		        'from_email' => 'info@x-presscards.com',
		        'from_name' => 'X-Press Cards',
		        'to' => array(
		            array(
		                'email' => $user->email,
		                'name' => $name,
		                'type' => 'to'
		            	)
		        	),
	    		);
			$mandrill->messages->send($message);
		}else{
			$email=false;
		}
		if(($phoneNumber)){
			Twilio::message($phoneNumber, $author->fullName().' has shared with you: '.$code);
		}else{
			$text=false;
		}
		return Response::json(array('input'=>Input::all(),'transfer'=>$transfer,'user'=>$user->toArray(),'email'=>$email,'text'=>$text));
	}

	/**
	 * Display the specified resource.
	 * GET /transferapis/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /transferapis/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /transferapis/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /transferapis/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}