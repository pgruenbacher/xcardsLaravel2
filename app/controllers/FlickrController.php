<?php

class FlickrController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	 // get fb service
		$api_key=Config::get('anahkiasen/flickering/config.api_key');
		$api_secret=Config::get('anahkiasen/flickering/config.api_secret');
		$method = Flickering::handshake($api_key,$api_secret);
		return '$method';
		//$fb=OAuth::consumer('LinkedIn');
		$flicker=OAuth::consumer('Flickr');
		echo '<pre>';
		print_r($method);
		return '</pre>';
		//$url = $fb->getAuthorizationUri();
		//$url= $fb->getAuthorizationUri();
		return $url;
		return Redirect::to( (string)$url );
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}