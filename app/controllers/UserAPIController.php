<?php

class UserAPIController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /userapis
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /userapis/create
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /userapis
	 *
	 * @return Response
	 */
	public function store()
	{
		$validate=Validator::make(Input::all(),
		array(
		'first'=>'required',
		'last'=>'required',
		'email'=> 'required|max:50|email|unique:users,email,NULL,id,active,1',
		'password'=> 'required|min:6',
		'password2'=> 'required|same:password',
		'address'=>'required',
		));
		if($validate->fails()){
			return Response::json(array('error'=>$validate->messages()->toArray()));
		}else{
			$address=Input::get('address');
			$email=Input::get('email');
			$code=str_random(60);
			$user=new User;
			$user->guest=0;
			$user->first=Input::get('first');
			$user->last=Input::get('last');
			$user->email=$email;
			$user->code=$code;
			$user->password=Hash::make(Input::get('password'));
			$user->active=0;
			$saved=$user->save();
			//Save address of user
			$address_data=array(
			'addressee'=>array($user->first.' '.$user->last),
			'address'=>array($address),
			'email'=>array($email),
			);
			$addresses=new Addresses;
			$addresses->saveArray($user,$address_data);	
			if($saved){
				$mandrill=new Mandrill(Config::get('mandrill.api_key'));
				$html=View::make('emails.auth.activate')->with(array(
					'name'=>$user->fullName(),
					'link'=>URL::route('account-activate',$code)
				));
				$html=$html->render();
				 $message = array(
			        'html' => $html,
			        'text' => $html,
			        'subject' => 'activate account',
			        'from_email' => 'info@x-presscards.com',
			        'from_name' => 'X-Press Cards',
			        'to' => array(
			            array(
			                'email' => $user->email,
			                'type' => 'to'
			            	)
			        	),
		    		);
				$mandrill->messages->send($message);
				
				return Response::json(array('status'=>'success','user'=>$user->toArray()));
			}
			else{
				return Response::json(array('status'=>'failure'));
			}
		}
	}
	/**
	 * Display the specified resource.
	 * GET /userapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($email)
	{
		
	}
	public function find(){
		if(Input::has('filter')&&Input::has('where')){
			$where=Input::get('where');
			$filter=Input::get('filter');
			$user=User::where($where,'=',$filter)->get()->first();
			if(! isset($user->id)){
				return Response::json(array(
					'status'=>'notfound'
				));
			}
			else{
				return Response::json(array(
					'user'=>$user->toArray(),
					'status'=>'found'
				));
			}
		}else{
			return Response::json(array(
				'error'=>'missing parameters filter or where'
			));
		}
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /userapi/{id}/edit
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
	 * PUT /userapi/{id}
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
	 * DELETE /userapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}