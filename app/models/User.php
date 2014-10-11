<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $fillable=array('first','last','email','username','password','password_temp','code','active','regIP');
	
	protected $guarded='password';
	
	 /*
	 * The database table used by the model.
	 *
	 * @var string
	 */

	  
  	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function fullName(){
		return $this->first.' '.$this->last;
	}
	public function splitFullName($name){
		if(strpos($name,' ')){
			list($fname, $lname) = explode(' ', $name,2);
			$this->first=$fname;
			$this->last=$lname;
		}else{
			$this->first=$name;
			$this->last=' ';
		}
		
	}
	public function getReminderEmail()
	{
		return $this->email;
	}
	public function userAddress(){
		return $this->hasMany('Addresses')->where('email','=',$this->email);
	}
	public function addresses(){
		return $this->hasMany("Addresses")->orderBy('created_at','desc');
	}
	public function smartyStreet(){
		return $this->hasManyThrough("SmartyStreet","Addresses");
	}
	public function orders()
	  {
	    return $this->hasMany("Orders")->orderBy('created_at','desc');
	  }
	public function cards(){
		return $this->hasMany('Cards','user_id')->orderBy('created_at','desc');
	}
	public function roles(){
		return $this->belongsToMany('Roles');
	}
	public function hasRole($check)
    {
        return in_array($check, array_fetch($this->roles->toArray(), 'type'));
    }
	public function incomingTransfers(){
		return $this->hasMany('Transfers','recipient_id')->orderBy('created_at','desc');
	}
	public function outgoingTransfers(){
		return $this->hasMany('Transfers','giver_id')->orderBy('created_at','desc');
	}
  	/*
	 * Tokens
	 * 
	 */
	 public function getRememberToken(){
	 	return $this->remember_token;
	 }
	 public function setRememberToken($value){
	 	$this->remember_token=$value;
	 }
	 public function getRememberTokenName(){
	 	return 'remember_token';
	 }
	 public function recoverPassword(){
	 	$code=str_random(60);
		$password=str_random(10);
		$this->code=$code;
		$this->password_temp=Hash::make($password);
		if($this->save()){
			$mandrill=new Mandrill(Config::get('mandrill.api_key'));
			$html=View::make('emails.auth.forgot')->with(array(
				'link'=>URL::route('account-recover',$code),
				'username'=>$this->first,
				'password'=>$password
			));
			$html=$html->render();
			$message = array(
		        'html' => $html,
		        'text' => $html,
		        'subject' => 'your new password',
		        'from_email' => 'info@x-presscards.com',
		        'from_name' => 'X-Press Cards',
		        'to' => array(
		            array(
		                'email' => $this->email,
		                'name' => $this->fullName(),
		                'type' => 'to'
		            	)
		        	),
	    		);
			$mailed=$mandrill->messages->send($message); 
		}
		if($mailed){
			return true;
		}else{
			return false;
		}
	 }
	 protected static function boot(){
	 	parent::boot();
		static::deleting(function($user) { // before delete() method call this
             $user->addresses()->delete();
			 $incomingTransfers=$user->incomingTransfers()->get();
			 $incomingTransfers->each(function($transfer){
			 	$transfer->delete();
			 });
			 $cards=$user->cards()->get();
			 $cards->each(function($card){
			 	$card->delete();
			 });
			 $outgoingTransfers=$user->outgoingTransfers()->get();
			 $outgoingTransfers->each(function($transfer){
			 	$transfer->delete();
			 });
        });
	 }
 }