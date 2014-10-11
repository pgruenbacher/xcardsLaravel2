<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '717864551585574',
            'client_secret' => '614dafd596299816c1d87adceb49aca3',
            'scope'         => array('email','user_photos','user_location'),
        ),
        /*
		 * Flickr
		 */	
	 	'Flickr' => array(
            'client_id'     => '641e676b8937a4f90e7e7dac967bef01',
            'client_secret' => 'e476950f49c9b65d',
        ),	
        'Google' => array(
            'client_id'     => '556597131119488',
            'client_secret' => '9a9d1461e1a365000a807e61f9d3ebe1',
            'scope'         => array('email','read_friendlists','user_online_presence'),
        ),
        'LinkedIn' => array(
            'client_id'     => 'dbacf0ee-b347-4bd2-9a41-7e0192c11317',
            'client_secret' => '91aabd18-ccb0-463c-b19a-44c06be6daa7',
        ),
	)

);