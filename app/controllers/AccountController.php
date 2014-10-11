<?php

class AccountController extends BaseController{
		
	public function getSignIn(){
		return View::make('account.signin');
	}
	public function postSignIn(){
		$validator=Validator::make(Input::all(),
		array( 
			'email'=>'required|email',
			'password'=>'required'
			)
		);
		if($validator->fails()){
			return Redirect::route('account-sign-in')
			->withErrors($validator)
			->withInput();
		}
		else{			
			$remember=(Input::has('remember'))? true : false;
			$auth=Auth::attempt(array(
			'email'=>Input::get('email'),
			'password'=>Input::get('password'),
			'active'=>1
			),$remember);
			if($auth){
				if(Session::has('user')&&Session::has('card')){
					$user=User::find(Session::get('user'));
					if(isset($user->cards()->first()->id)){
						$card=$user->cards()->first()->id;
						Cards::find($card)->user()->associate(Auth::user())->save();
						$addresses=$user->addresses()->get();
						foreach($addresses as $address){
							Addresses::find($address->id)->user()->associate(Auth::user())->save();
						}
					}
					
				}
				return Redirect::intended('/home');
			}
			else{
				return Redirect::route('account-sign-in')
				->with('global','Incorrect email or password');
			}
		}
		return Redirect::route('account-sign-in')
		->with('global','There was a problem signing you in. Have you activated your account?');
	}
	public function registered($code){
		
			$user = User::where('code','=',$code)->where('active','=','0');
			if($user->count()){
				$user=$user->first();
				return View::make('account/premade')->with(array(
				'user'=>$user,
				'code'=>$code,
				));
			}
			return Redirect::route('account-sign-in')
				->with('global','Sorry that link may have timed out, try checking your email');
	}
	public function postRegistered(){
		$input=Input::all();
		$validate=Validator::make($input,
			array(
			'user'=>'required',
			'first'=>'required',
			'last'=>'required',
			'email'=> 'required|max:50|email',
			'old_password'=>'required',
			'password'=> 'required|min:6',
			'password_again'=> 'required|same:password',
			'address'=>'required',
			));
		if($validate->fails()){
			return Redirect::route('account-registered',$input['code'])
			->withErrors($validate)
			->withInput();
		}else{
			$user=User::find(Input::get('user'));
			if(Hash::check(Input::get('old_password'),$user->password)){
				$user->password=Hash::make($input['password']);
				$user->email=$input['email'];
				$user->first=$input['first'];
				$user->last=$input['last'];
				$user->active=1;
				$user->save();
				//Save address
				$address_data=array(
				'addressee'=>array($user->fullName()),
				'address'=>array(Input::get('address')),
				'email'=>array(Input::get('email')),
				);
				$addresses=new Addresses;
				$addresses->saveArray($user,$address_data);	
			}else{
				return Redirect::route('account-registered',$input['code'])
				->with('error_password','incorrect temporary password, check the password given to you in email')
				->withInput();
			}
			if(Auth::attempt(array(
			'email'=>$input['email'],
			'password'=>$input['password'],
			'active'=>1,
			),true)){
				return Redirect::route('home');
			}
			
		}
		
	}

	public function getSignOut(){
		Auth::logout();
		return Redirect::route('splash');
	}
	
	public function getCreate(){
		return View::make('account.create');
	}
	public function postCreate(){
		$validate=Validator::make(Input::all(),
		array(
		'first'=>'required',
		'last'=>'required',
		'email'=> 'required|max:50|email|unique:users,email,NULL,id,active,1',
		'password'=> 'required|min:6',
		'password_again'=> 'required|same:password',
		'address'=>'required',
		));
		if($validate->fails()){
			return Redirect::route('account-create')
			->withErrors($validate)
			->withInput();
		}else{
			$first=Input::get('first');
			$last=Input::get('last');
			$email=Input::get('email');
			$password=Input::get('password');
			$address=Input::get('address');
			//Activation Code
			$code=str_random(60);
			if(Session::has('user')){
				$user=User::find(Session::get('user'));
			}
			if(! isset($user)){
				$user=new User;
			}
			$user->guest=0;
			$user->first=$first;
			$user->last=$last;
			$user->email=$email;
			$user->password=Hash::make($password);
			$user->code=$code;
			$user->active=0;
			$user->save();
			//Save address of user
			$address_data=array(
			'addressee'=>array($user->first.' '.$user->last),
			'address'=>array($address),
			'email'=>array($email),
			);
			$addresses=new Addresses;
			$addresses->saveArray($user,$address_data);	
			if($user){
				$mandrill=new Mandrill(Config::get('mandrill.api_key'));
				$html=View::make('emails.auth.activate')->with(array(
					'link'=>URL::route('account-activate',$code),
					'name'=>$user->fullName()
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
			                'name' => $user->first,
			                'type' => 'to'
			            	)
			        	),
		    		);
				$mandrill->messages->send($message);
				
				return Redirect::route('account-sign-in')
				->with('global','Your account has been created, we have sent you an email to activate your account');
			}
		}
		
	}
	public function getActivate($code){
		$user = User::where('code','=',$code)->where('active','=','0');
		if($user->count()){
			$user=$user->first();
			//Update user to active state
			$user->active =1;
			$user->code ='';
			
			if($user->save()){
				return Redirect::route('account-sign-in')
				->with('global','Congratulations your account has been activated, you may now sign in');
			}
		}
		return Redirect::route('account-sign-in')
			->with('global','Sorry we could not activate your account try again later');
		
	}
	
	public function getChangePassword(){
		return View::make('account.password');
	}
	public function postChangePassword(){
		$validator=Validator::make(Input::all(), array(
		'old_password'=>'required',
		'password'=>'required|min:6',
		'password_again'=>'required|same:password'
		));
		if($validator->fails()){
			return Redirect::route('account-change-password')
			->withErrors($validator);
		}else{
			$user=Auth::user();
			$old_password=Input::get('old_password');
			$password=Input::get('password');
			if(Hash::check($old_password,$user->getAuthPassword())){
				$user->password=Hash::make($password);
				if($user->save()){
					return Redirect::route('home')
					->with('global','Your password has been changed');
				}
			}else{
				return Redirect::route('account-change-password')
				->with('global','Your old password is not correct');
			}
			
		}
		Redirect::route('account-change-password')
		->with('global','your password could not be changed');
	}
	public function getForgotPassword(){
		return View::make('account.forgot');
	}
	public function postForgotPassword(){
		$validator=Validator::make(Input::all(),array(
			'email'=>'required|email'
		));
		if($validator->fails()){
			return Redirect::route('account-forgot-password')
			->withErrors($validator)
			->withInput();
			
		}else{
			$user=User::where('email','=',Input::get('email'));
			if($user->count()){
				$user=$user->first();
				//Generate a new code and password
				if($user->recoverPassword()){
					
					return Redirect::route('account-sign-in')
					->with('global','we have sent you a new password by email');
				}
				
			}
		}
		return Redirect::route('account-forgot-password')
		->with('global','could not request new password');
	}
	public function getRecover($code){
		$user=User::where('code','=',$code)
		->where('password_temp','!=','');
		if($user->count()){}
		$user=$user->first();
		if(isset($user->password_temp)){
			$user->password=$user->password_temp;
		}else{
			return Redirect::route('account-sign-in')
			->with('global','You already have used this link, check your email for a new password sent to you');
		}
		
		$user->password_temp='';
		$user->code='';
		if($user->save()){
			return Redirect::route('account-sign-in')
		->with('global','your account has been recovered, and you can sign in with your new password');
		}else{
			return Redirect::route('account-sign-in')
		->with('global','could not recover your account');
		}
	}
	public function authenticateAction()
	  {
	    $credentials = array(
	      "email"    => Input::get("email"),
	      "password" => Input::get("password")
	    );
	
	    if (Auth::attempt($credentials))
	    {
	      return Response::json(array(
	        "status"  => "ok",
	        "account" => Auth::user()->toArray()
	      ));
	    }
	
	    return Response::json(array(
	      "status" => "error"
	    ));
	  }
	
}

?>