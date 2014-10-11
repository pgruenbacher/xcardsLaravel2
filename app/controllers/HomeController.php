<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home()
	{
		if(Auth::check()){
			$user=Auth::user();
			$addresses=$user->addresses()->take(10)->get();
			$cards=$user->cards()->where('cardsetting_id','!=',0)->take(5)->get();
			$incomingTransfers=$user->incomingTransfers()->where('confirmed','=',0)->get();
			$outgoingTransfers=$user->outgoingTransfers()->take(5)->get();
		
			return View::make('home')->with(array(
				'cards'=>$cards,
				'addresses'=>$addresses,
				'incomingTransfers'=>$incomingTransfers,
				'outgoingTransfers'=>$outgoingTransfers,
			));
		}
	}
	public function faq(){
		return View::make('splash.FAQ');
	}
	public function terms(){
		return View::make('splash.terms');
	}
	public function privacy(){
		return View::make('splash.privacy');
	}
	public function splash(){
		return View::make('splash.splash');
	}
	public function printing(){
		return View::make('splash.printing');
	}
	public function contact(){
		$user=Auth::user();
		return View::make('splash.contact');
	}
	public function company(){
		return View::make('splash.company');
	}
	public function fanpage(){
		if(Request::isMethod('get')){
			return View::make('splash.fanpage');
		}else if(Request::isMethod('post')){
			$petName=Input::get('pet');
			$pet=Pets::where('name','=',$petName)->firstOrFail();
			return Redirect::route('build-index')->with('pet',$pet->id);
		}
	}
	public function contactPost(){
		$validator=Validator::make(Input::all(),
		array( 
			'email'=>'required|email',
			'subject'=>'required',
			'text'=>'required'
			)
		);
		if($validator->fails()){
			return Redirect::route('contact')
			->withErrors($validator)
			->withInput();
		}else{
			$form=new ContactForms;
			$form->text=Input::get('text');
			$form->subject=Input::get('subject');
			$form->email=Input::get('email');
			$form->save();
			$mandrill=new Mandrill(Config::get('mandrill.api_key'));
			$message = array(
		        'html' => Input::get('text'),
		        'text' => Input::get('text'),
		        'subject' => Input::get('subject'),
		        'from_email' => Input::get('email'),
		        'from_name' => 'X-Press Cards Contact Form',
		        'to' => array(
		            array(
		                'email' => 'contact@x-presscards.com',
		                'name' => 'X-press Cards',
		                'type' => 'to'
		            	)
		        	),
	    		);
			$mandrill->messages->send($message);
			return Redirect::route('contact')
			->with('global','We sent your form');
		}
	}
	public function previous(){
			$user=Auth::user();
			$cards=$user->cards()->where('cardsetting_id','!=',0)->get();
			return View::make('build.previous')->with(array(
			'cards'=>$cards,
			'user'=>$user,
			));
	}
	public function exchange(){
		
		if(Request::isMethod('get')){
			$user=Auth::user();
			$addresses=$user->addresses()->get();
			return View::make('home/exchange')->with(array(
			'addresses'=>$addresses,
			'user'=>$user,
			));
		}else if(Request::isMethod('post')){
			$max=Auth::user()->credits;
			$input=Input::all();
			$addressCheck=Input::has('addressCheck');
			$creditCheck=Input::has('creditCheck');
			$validator=Validator::make(
			array('email'=>Input::get('email'),'name'=>Input::get('name'),'credits'=>Input::get('credits'),'addresses'=>Input::get('addreses'),'sendCredits'=>Input::get('creditCheck'),'sendAddresses'=>Input::get('addressCheck')),
			array(
			'email'=>'required',
			'credits'=>'required_with:sendCredits|integer|between:0,'.$max,
			));
			$validator->sometimes('addresses', 'required', function($addressCheck){
			    if($addressCheck){
			    	$addresses=Input::get('addresses');
			    	if(empty($addresses)){return true;}else{return false;}
			    }
			});
			$validator->sometimes('name', 'required', function($input){
			    return !isset(User::where('email','=',$input['email'])->where('active','=','1')->first()->id);
			});
			if($validator->fails()){
				return Redirect::route('exchange')->withErrors($validator);
			}else{
				$email=Input::get('email');
				$user=User::where('email','=',$email)->where('active','=','1')->first();
				$name=Input::get('name');
				if(! isset($user->id)){
					$user=new User;
					$user->email=$email;
					$user->splitFullName($name);
					$password=str_random(6);
					$user->password=Hash::make($password);
					$code=str_random(60);
					$user->code=$code;
					$user->active=0;
					$user->save();
					$user_id=DB::connection('mysql')->getPdo()->lastInsertId();
				}else{
					$user_id=$user->id;
					$password=null;
					$code=null;
				}
				if(Input::has('addressCheck')){
					$address_ids=Input::get('addresses');
					$addresses=Addresses::find($address_ids);
					foreach($addresses as $address){
						$address->copyTo($user_id);
						}
				}else{
					$addresses=null;
				}
				if(Input::has('creditCheck')){
					$credits=Input::get('credits');
					$transfer=new Transfers;
					$transfer->recipient_id=$user_id;
					$transfer->giver_id=Auth::user()->id;
					$transfer->credits=$credits;
					$transfer->save();
					Auth::user()->credits -= $credits;
					Auth::user()->save();
				}else{
					$credits=null;
				}
				$mandrill=new Mandrill(Config::get('mandrill.api_key'));
				$html=View::make('emails.auth.share-activate')->with(array(
					'link'=>URL::route('account-registered',$code),
					'user'=>$user,
					'credits' =>$credits,
			        'addresses'=>$addresses,
			        'password'=>$password,
			        'auth'=>Auth::user(),
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
			}
			$globalMessage='We have shared with '.$user->fullName();
			return Redirect::route('home')->with('global',$globalMessage);

		}
	}
	public function confirmExchange(){
		if(Input::has('transfers')){
			$transfers=Transfers::find(Input::get('transfers'));
			if(Input::get('accept')){
				foreach($transfers as $transfer){
					if(! $transfer->accept()){
						return false;
					}
				}
				return json_encode(array('status'=>'success'));
			}else{
				foreach($transfers as $transfer){
					if(! $transfer->accept()){
						return false;
					}
				}
			}
		}else{
			return false;
		}
	}

}