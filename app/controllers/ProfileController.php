<?php

class ProfileController extends BaseController{
	public function user($username){
		$user=User::where('user','=',$username);
		if($user->count()){
			$user=$user->first();
			return View::make('profile.user')
			->with('user',$user);
		}
		else{
			return App::abort(404);
		}
	}
}

?>