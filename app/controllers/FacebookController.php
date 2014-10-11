<?php

class FacebookController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /facebook
	 *
	 * @return Response
	 */
	public function login()
	{
		
		 // get data from input
	    $code = Input::get( 'code' );
	
	    // get fb service
	    $fb = OAuth::consumer( 'Facebook' );
	    // check if code is valid
	
	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {
	        // This was a callback request from facebook, get the token
	        $token = $fb->requestAccessToken( $code );
			$t=$token->getAccessToken();
			// Send a request with it
	        $info = json_decode( $fb->request( '/me' ), true );
			$birthdays = json_decode( $fb->request( 'me/friends?fields=location,picture,birthday' ), true );
			//$tagged = json_decode( $fb->request( '/me/photos' ), true );
			$user=User::where('email','=',$info['email'])->where('active','=',1)->get();
			if (isset($user)){
				Auth::login($user->first(),true);
			}else{
				$user = new User;
				$user->facebook_id=$info['id'];
				$user->first=$info['first_name'];
				$user->last=$info['last_name'];
				$user->email=$info['email'];
				$user->facebook_token=$t;
				$user->active=1;
				$user->save();
				Auth::login($user,true);
			}
			return Redirect::route('home');
	        
	
	    }
	    // if not ask for permission first
	    else {
	        // get fb authorization
	        $url = $fb->getAuthorizationUri();
	
	        // return to facebook login url
	         return Redirect::to( (string)$url );
	    }
	
	}
	
	
	public function image(){
		if(Auth::check()){
			$user=Auth::user();
		}else{
			$user=User::find(Session::get('user'));
		}
		 // get data from input
	    $code = Input::get( 'code' );
	
	    // get fb service
	    $fb = OAuth::consumer( 'Facebook' );
	    // check if code is valid
	
	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {
	        // This was a callback request from facebook, get the token
	        $token = $fb->requestAccessToken( $code );
			$t=$token->getAccessToken();
			$user->facebook_token=$t;
			$user->save();
			// Send a request with it
	        $result = json_decode( $fb->request( '/me/photos/uploaded' ), true );
			//$tagged = json_decode( $fb->request( '/me/photos' ), true );
			
			return View::make('facebook.facebook-collage')->with(array(
				'media'=>$result,
				'user'=>$user,
			));
	        
	
	    }
	    // if not ask for permission first
	    else {
	        // get fb authorization
	        $url = $fb->getAuthorizationUri();
	
	        // return to facebook login url
	         return Redirect::to( (string)$url );
	    }
	}
	/**
	 * Show the form for creating a new resource.
	 * GET /facebook/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /facebook
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /facebook/{id}
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
	 * GET /facebook/{id}/edit
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
	 * PUT /facebook/{id}
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
	 * DELETE /facebook/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}