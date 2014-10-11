<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
View::composer(array('administrator::layouts.default'), function($view)
{
    $view->js['my_dashboard_script'] = URL::asset('js/administrator/dashboard.js');
	$view->css['my_jquery_ui']="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css";
    $view->css['my_dashboard_script'] = URL::asset('css/administrator/dashboard.css');
});
Profiler::disable();
Route::get('cronTest',function(){
	$currentTime=time();
			$oldTime=date('Y-m-d H:i:s',$currentTime-60*60*24*2);
        	$oldTransfers=Transfers::where('confirmed','=',0)->where('created_at','<',$oldTime)->get();
			foreach($oldTransfers as $oldTransfer){
				$oldTransfer->revert();
			}
});
Route::get('tracking',function(){
	$card=Cards::find(511);
	return $card->anyImage()->get();
	$collage=Collages::find(64);
	return $collage->images()->get();
	// Initiate and set the username provided from usps
	$delivery = App::make('XCards\USPS\DeliveryCalculatorInterface');
	$delivery->setUsername(Config::get('development/USPS.username'));
	// During test mode this seems not to always work as expected
	$delivery->setTestMode(true);
	
	// Add the zip code we want to lookup the city and state
	$delivery->addRoute(3, '43214', '45014');
	
	// Perform the call and print out the results
	echo '<pre>';
	print_r($delivery->getServiceDeliveryCalculation());
	echo '<br>';
	print_r($delivery->getArrayResponse());
	echo '</pre>';
	
	// Check if it was completed
	if($delivery->isSuccess()) {
	  echo 'Done';
	} else {
	  echo 'Error: ' . $delivery->getErrorMessage();
	}
	
	
	$tracking=App::make('XCards\USPS\TrackingInterface');
	// During test mode this seems not to always work as expected
	$tracking->setTestMode(true);
	$tracking->setUsername(Config::get('development/USPS.username'));
	// Add the test package id to the trackconfirm lookup class
	$tracking->addPackage("EJ958083578US");
	print_r($tracking->getPostFields());
	echo '<br>';
	print_r($tracking->getEndpoint());
	echo '<br>';
	// Perform the call and print out the results
	print_r($tracking->getTracking());
	echo '<br>';
	print_r($tracking->getArrayResponse());
	echo '<br>';
	print_r($tracking->convertResponseToArray());
	// Check if it was completed
	if($tracking->isSuccess()) {
	  echo 'Done';
	} else {
	  echo 'Error: ' . $tracking->getErrorMessage();
	}
});
Route::group(array('prefix'=>'mobile','before'=>'angularFilter'),function(){

	Route::get('oauth/access_token',function(){
			return AuthorizationServer::performAccessTokenFlow();
		});
	Route::post('userAPI','UserAPIController@store');
	Route::group(array('before'=>'oauth'),function(){
		Route::get('user/auth',function(){
			$user=User::find(ResourceServer::getOwnerId());
			Auth::login($user);
			return Response::json(array($user->toArray()));
		});
		Route::resource('transferAPI','TransferAPIController');
		Route::get('userAPI/find','UserAPIController@find');
		Route::resource('userAPI','UserAPIController', array('except' => array('store')));
		Route::resource('addressesAPI','AddressesAPIController');
	});
});
/*
 * Authenticated Group
 */	
Route::group(array('before'=>'auth'),function(){
	 
	/*
	 * CSRF Protection Filter, see filters **************
	 */
	Route::group(array('before'=>'csrf'),function(){
		/*
		 * Change Password (POST)
		 */ 
		 Route::post('/account/change-password',array(
		 'as'=>'account-change-password-post',
		 'uses'=>'AccountController@postChangePassword'
			 ));
		 /*
		  * Credit Charge (POST)
		  */
		Route::post('/buy',array(
			'as'=>'stripe-charge',
			'uses'=>'StripeController@charge'
		)); 
		/*
		 * Purchase Cards (POST)
		 */
			Route::post('/purchase',array(
				'as'=>'purchase-cards',
				'uses'=>'StripeController@purchase'
			));
	}); //END CSRF ********************
	/*
	 * Home Page
	 */
	
	Route::get('/home',array(
		'as'=>'home',
		'uses'=>'HomeController@home'
		));
	/*
	 * Exchange Credits
	 */
	Route::match(array('GET','POST'),'/exchange',array(
		'as'=>'exchange',
		'uses'=>'HomeController@exchange'
		));
	/*
	 * Ajax confirm Credits
	 */	
	Route::post('/confirmExchange','HomeController@confirmExchange');
	/*
	 * Validation route for ajax forms
	 */
	Route::post('validation',function(){
		$validate=Validator::make(Input::all(),
		array(
		'email'=> 'unique:users,email,NULL,id,active,1',
		));
		if($validate->fails()){
			$user=User::where('email','=',Input::get('email'))->where('active','=',1)->first();
			return json_encode(array('exists'=>true,'name'=>$user->fullName()));
		}else{
			return json_encode(Input::all());
		}
	});
	Route::post('updateCredits',function(){
		return json_encode(array('credits'=>Auth::user()->credits));
	});
	/*
	 * Admin
	 */
	 Route::post('admin/download',array(
	 'uses'=>'AdminController@download'
	 ));
	/*
	 *Shopping Cart (GET) 
	 */
	Route::get('/buy',array(
	'as'=>'buy-credits',
	'uses'=>'StripeController@index',
	));
	
	/*
	 * Sign Out (GET)
	 */ 
	 Route::get('/account/sign-out',array(
	 'as'=>'account-sign-out',
	 'uses'=>'AccountController@getSignOut'
	 ));
	 /*
	 * Change Password (GET)
	 */ 
	 Route::get('/account/change-password',array(
	 'as'=>'account-change-password',
	 'uses'=>'AccountController@getChangePassword'
	 ));
 	/*
	 * Get Addresses (GET)
	 */
	 Route::get('address-book/data','AddressesController@data');
	 Route::get('address-book/editor','AddressesController@editor');
	 Route::resource('address-book','AddressesController');
	
	/*
	 *  Import Emails
	 */
	 Route::get('/request',array(
	 'as'=>'request-addresses',
	 'uses'=>'CloudSpongeController@index'
	 ));
	 
	 Route::post('/email',array(
	 'as'=>'request-address-post',
	 'uses'=>'CloudSpongeController@email'
	 ));
	
	/*
	 * Build Routes
	 */
	Route::post('build/final',array(
		'as'=>'build-final',
		'uses'=>'BuildController@finalize'
	));
	Route::get('previous',array(
		'as'=>'build-previous',
		'uses'=>'HomeController@previous'
	));

	Route::get('redirect',function(){
		if(Input::has('id') && Input::has('url')){
			Session::put('card',Input::get('id'));
			return Redirect::route(Input::get('url'));
		}
	});
	 
	
	Route::get('amazon',function(){
		
		$source_file= 'C:\xampp\htdocs\series\dynamic\xcards\public\packages\andrew13\cabinet\uploads\2014\04\30\SXp7RmY.jpg';
		$keyname='image-uploads/'.date('Y-m-d').'/'.str_random(15).'-'.'nameoffile';
		$s3 = App::make('aws')->get('s3');
		
		try{
			$result= $s3->putObject(array(
			    'Bucket'     => 'xpress_cards',
			    'Key'        => $keyname,
			    'SourceFile' => $source_file,
			    'ACL'          =>'public-read',
				));
			return $result['ObjectURL'];
		}
		catch (S3Exception $e) {
    		echo $e->getMessage() . "\n";
			}
		
	});
		
});
	
/*
 * Unauthenticated Group
 */		
Route::group(array('before'=>'guest'),function(){
	
	/*
	 * CSRF Protection Filter, see filters
	 */
	Route::group(array('before'=>'csrf'),function(){
		/*
		 * Sign in POST
		 */
		 Route::post('/account/sign-in',array(
		 'as'=>'account-sign-in-post',
		 'uses'=>'AccountController@postSignIn'
		 ));
		/*
		 * Create account POST
		 */
		 Route::post('/account/create',array(
		 'as'=>'account-create-post',
		 'uses'=>'AccountController@postCreate'
		 ));
		 /*
		 * Forgot Password POST
		 */
		 Route::post('/account/forgot-password',array(
		 'as'=>'account-forgot-password-post',
		 'uses'=>'AccountController@postForgotPassword'
		 ));
		 /*
		  * Registered
		  */
	   Route::post('/account/registered',array(
		 'as'=>'account-registered-post',
	 	'uses'=>'AccountController@postRegistered'
	 ));
		 
		
	});
	/*
	 * SPLASH PAGE
	 */
	 Route::get('/',array(
		'as'=>'splash',
		'uses'=>'HomeController@splash'
		));
	
	/*
	 * Forgot Password(GET)
	 */
	 Route::get('/account/forgot-password',array(
	 'as'=>'account-forgot-password',
	 'uses'=>'AccountController@getForgotPassword'
	 ));
	
	/*
	 * Recover Password(GET)
	 */
	 Route::get('/account/recover/{code}',array(
	 'as'=>'account-recover',
	 'uses'=>'AccountController@getRecover'
	 ));
	
	/*
	 * Sign In (GET)
	 */
	 Route::get('/account/sign-in',array(
	 'as'=>'account-sign-in',
	 'uses'=>'AccountController@getSignIn'
	 ));
	/*
	 * Facebook log in 
	 */
	 Route::get('account/facebook',array(
	 'as'=>'facebook-login',
	 'uses'=>'FacebookController@login',
	 ));
	/*
	 * Create account (GET)
	 */
	 Route::get('/account/create',array(
	 'as'=>'account-create',
	 'uses'=>'AccountController@getCreate'
	 ));
	 
	 Route::get('/account/activate/{code}',array(
	 	'as'=>'account-activate',
		'uses'=>'AccountController@getActivate'
		));
	/*
	  * Registered user
	  */
	  Route::get('/account/registered/{code}',array(
		 'as'=>'account-registered',
	 	'uses'=>'AccountController@registered'
	 ));

}); //End Unauthenticated Group
	
	

	Route::get('/address-request-form/{code}/{email}',array(
		 'as'=>'address-request-form',
		 'uses'=>'CloudSpongeController@form'
		 ));	
 	/*
	 *  Footer routes
	 */
	Route::get('/FAQ',array(
	 	'as'=>'faq',
	 	'uses'=>'HomeController@faq'
 		));
	Route::get('/terms',array(
		'as'=>'website-terms',
		'uses'=>'HomeController@terms'
		));
	Route::get('/privacy',array(
		'as'=>'privacy',
		'uses'=>'HomeController@privacy'
		));
	Route::get('/contact',array(
		'as'=>'contact',
		'uses'=>'HomeController@contact'
		));
	Route::post('/contact/post',array(
		'as'=>'contact-post',
		'uses'=>'HomeController@contactPost'
		));
	Route::get('/printing',array(
		'as'=>'printing',
		'uses'=>'HomeController@printing'
		));
	Route::get('/company',array(
		'as'=>'company',
		'uses'=>'HomeController@company'
		));
	Route::match(array('GET','POST'),'/fanpage',array(
		'as'=>'fanpage',
		'uses'=>'HomeController@fanpage'
		));
	/*
	 * Build routes
	 */
	Route::get('build',array(
	'as'=>'build-index',
	'uses'=>'BuildController@index'));
	Route::match(array('GET','POST'),'build/image',array(
		'as'=>'build-process',
		'uses'=>'BuildController@process'
	));
	Route::match(array('GET','POST'),'build/edit',array(
		'as'=>'build-crop',
		'uses'=>'BuildController@crop'
	));
	Route::match(array('GET','POST'),'build/send',array(
		'as'=>'build-send',
		'uses'=>'BuildController@send'
	));
	Route::get('build/retrieve',array(
		'as'=>'build-retrieve',
		'uses'=>'BuildController@retrieve'
	));
	Route::match(array('GET','POST'),'build/preview',array(
		'as'=>'build-preview',
		'uses'=>'BuildController@preview'
	));
	
	/*
	 * Instagram
	 */ 
 	Route::get('instagram',array(
		'as'=>'instagram',
		'uses'=>'InstagramController@index'
	));
	Route::post('instagram/process',array(
	'as'=>'instagram-process',
	'uses'=>'InstagramController@process'
	));
	Route::match(array('GET','POST'),'instagram/edit',array(
		'as'=>'instagram-edit',
		'uses'=>'BuildController@crop'
	));
	Route::match(array('GET','POST'),'instagram/send',array(
		'as'=>'instagram-send',
		'uses'=>'BuildController@send'
	));
	Route::match(array('GET','POST'),'instagram/preview',array(
		'as'=>'instagram-preview',
		'uses'=>'BuildController@preview'
	));
	/*
	 * Facebook Images
	 */
	Route::get('facebook/image',array(
		'as'=>'facebook-image',
		'uses'=>'FacebookController@image'
	));
	// Adding auth checks for the upload functionality is highly recommended.
	// Cabinet routes
	Route::get('upload/image',array(
			'as' => 'upload',
			'uses' => 'UploadController@image',
		));
	Route::match(array('GET','POST'),'upload/handler',array(
			'as' => 'upload-handler',
			'uses' => 'UploadController@handler',
		));
	Route::post('upload/save','UploadController@save');
	Route::get('upload/progress',array(
			'as'=>'upload-progress',
			'uses'=>'UploadController@progress'
		));
	/*
	 * Routes for Laravel Blog 
	 */
	// Main default listing e.g. http://domain.com/blog
	Route::get(Config::get('laravel-blog/routes.base_uri'), 'PostsController@index');
	// Archive (year / month) filtered listing e.g. http://domain.com/blog/yyyy/mm
	Route::get(Config::get('laravel-blog/routes.base_uri').'/{year}/{month}', 'PostsController@indexByYearMonth')->where(array('year' => '\d{4}', 'month' => '\d{2}'));
	if (Config::get('laravel-blog/routes.relationship_uri_prefix'))
	{
		// Relationship filtered listing, e.g. by category or tag, e.g. http://domain.com/blog/category/my-category
		Route::get(Config::get('laravel-blog/routes.base_uri').'/'.Config::get('laravel-blog/routes.relationship_uri_prefix').'/{relationshipIdentifier}', 'PostsController@indexByRelationship');
	}
	// Blog post detail page e.g. http://domain.com/blog/my-post
	Route::get(Config::get('laravel-blog/routes.base_uri').'/{slug}', 'PostsController@view');
	// RSS feed URL e.g. http://domain.com/blog.rss
	Route::get(Config::get('laravel-blog/routes.base_uri').'.rss', 'PostsController@rss');
	
	 
Route::group(array('before'=>'csrf'),function(){
	Route::post('address-request-post',array(
		'as'=>'address-request-post',
		'uses'=>'CloudSpongeController@post'
	));


});	

