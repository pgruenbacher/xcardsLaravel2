<?php

class CloudSpongeController
extends BaseController
{
  public function index()
  {
  	
  	if($check=Session::get('check')){
  		$contacts=Session::get('contacts');
  		return View::make('cloudsponge/cloudSponge')->with(array(
  		'check'=>$check,
  		'contacts'=>Session::get('contacts')
		));
  	}
    return View::make('cloudsponge/cloudSponge');
  }
  public function email()
  {
	
	$contacts=Input::all();
	$goAhead=Input::get('goAhead');
	$user=Auth::user();
	
	if(isset($contacts['email'])){
		$emails=$contacts['email'];
		$current_contacts = DB::table('addresses')
                    ->whereIn('email', $emails)->get();
	}else{$emails=array();}
	
	if(isset($contacts['address_id'])){
		foreach($contacts['address_id'] as $id){
			$address=Addresses::find($id);
			$smarty=SmartyStreet::where('addresses_id','=',$id)->first();
			$data = $address->toArray();
			$data2= $smarty->toArray();
			
			unset($data['id'],$data['updated_at'],$data['deleted_at']);
			$data['user_id']=$user->id;
			$data['created_at']=date('Y-m-d');
			$new_address=Addresses::insert($data);
			$id = DB::connection('mysql')->getPdo()->lastInsertId();
			unset($data2['id'],$data2['updated_at'],$data2['deleted_at']);
			$data2['created_at']=date('Y-m-d');
			$data2['addresses_id']=$id;
			$new_smarty=SmartyStreet::insert($data2);
			}
	}
	
	$check=array();
	if(! empty($current_contacts) && empty($goAhead)){
		foreach($current_contacts as $current_contact){
			foreach($emails as $email){
				if($current_contact->email==$email && $email!=''){
					$array=array(
					'email'=>$email,
					'address'=>$current_contact->address,
					'id'=>$current_contact->id,
					);
					$check[]=$array;
				}
			}
		}
		if(! empty($check)){
			return Redirect::route('request-addresses')->with(array(
		'check'=>$check,
		'contacts'=>$contacts
		));
		}
		
	}elseif(! empty($contacts['email'])){
		$to=array();
		$i=0;
		foreach($contacts['email'] as $contact){
			$to[$i]['name']=$contacts['name'][$i];
			$to[$i]['email']=$contact;
			$to[$i]['type']='to';
			$i++;	
		};
		$data=array();
		$id=Auth::user()->id;
		$user=User::find($id);
		if($user->url_temp==null){
			$code=str_random(60);
			$user->url_temp=$code;
		}else{
			$code=$user->url_temp;
		}
		$user->save();
		$data['code']=$code;
		$code2=array();
		$code2;
		$view=View::make('emails/address_request')->with('data',$data);
		$html=$view->render();
		$mandrill=new Mandrill(Config::get('mandrill.api_key'));
		 $message = array(
	        'html' => $html,
	        'text' => $html,
	        'subject' => 'address request',
	        'from_email' => 'info@x-presscards.com',
	        'from_name' => 'X-Press Cards',
	        'to' => $to,
	    	'preserve_recipients'=>false,
	    	"merge_vars" => array(
	                "rcpt"=> $contacts['email'],
	                "vars"=> array(
	                        "name"=> "code",
	                        "content"=> 'justanexample'
	                    ),
	          ),
			);
		$mandrill->messages->send($message);
	 	return Redirect::route('home')->with('global','we sent emails to those you requested');
	}elseif(empty($contacts['email'])){
		return Redirect::route('home')->with('global','we copied those entries you indicated to your address book. No email requests were sent out');
	}

	
  }
  public function check(){
  
  }
  public function form($code,$email)
  {
  	$user=User::where('url_temp','=',$code)->first();
	return View::make('addresses/form')
	->with(array(
		'user'=>$user,
		'email'=>$email
		));
  }
  public function post(){
  	$user=User::find(Input::get('user'));
	$address=new Addresses(array(
	'address'=>Input::get('address'),
	'addressee'=>Input::get('name'),
	'email'=>Input::get('email')
	));
	$user->addresses()->save($address);
	//Add to Smarty Street
	$street=new SmartyStreet;
	$verified=$street->street_secret(array(Input::get('address')));
	$flattened=$street->flatten($verified);	
	$smarty_street=new SmartyStreet($flattened[0]);
	$address->smartyStreet()->save($smarty_street);
	return Redirect::route('home')->with('global','Thank you for registering your address for '.$user['first'].', create an account to send your own!');
  }
}