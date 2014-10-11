<?php

class AddressesAPIController extends \BaseController {
	public function __construct(){
		$this->afterFilter(function ($route, $req, $resp) {
		    $resp->headers->set('Access-Control-Allow-Origin', '*');
		    return $resp;
		});
	}
	/**
	 * Display a listing of the resource.
	 * GET /addressapi
	 *
	 * @return Response
	 */
	public function index()
	{
		$user=User::find(ResourceServer::getOwnerId());
		$addresses=$user->addresses()->select('id','addressee','email','address')->take(10)->get()->toArray();
		return Response::json($addresses);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /addressapi/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /addressapi
	 *
	 * @return Response
	 */
	public function store()
	{
		// First we fetch the Request instance
		$address_data=Input::all();
		$user=User::find(ResourceServer::getOwnerId());
		$addresses=new Addresses;
		$street=new SmartyStreet;
		$verified=$street->street_secret(array($address_data['address']));
		$flattened=$street->flatten($verified);
		$new_date=date('Y-m-d');
		$data=array(
			'user_id'=>$user->id,
			'addressee'=>$address_data['addressee'],
			'email'=>$address_data['email'],
			'address'=>$address_data['address'],
			'created_at'=>$new_date
		);
		Addresses::insert($data);
		$id=DB::connection('mysql')->getPdo()->lastInsertId();
		$address=Addresses::find($id);
		if(isset($flattened[0])){
			$smarty_street=new SmartyStreet($flattened[0]);
			$smarty_street=$address->smartyStreet()->save($smarty_street);
		}
		return Response::json(array(
		'status'=>'success',
		'user'=>$user,
		'address'=>$address,
		'smarty'=>$smarty_street
		));
	}

	/**
	 * Display the specified resource.
	 * GET /addressapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Response::json(array('address'=>Addresses::find($id)->toArray()));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /addressapi/{id}/edit
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
	 * PUT /addressapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//return Response::json(array('status'=>'succes','fuck'=>'thisshit'));
		$address = Addresses::find($id);
		$address->addressee = Input::get('addressee');
		$address->email   = Input::get('email');
		if($address->address !== Input::get('address')){
			$address->address = Input::get('address');
			$addressMatch=false;
		}else{
			$addressMatch=true;
		}
		$updated=$address->save();
		if(!$addressMatch){
			//Store Smarty Street Verified			
			$street=new SmartyStreet;
			$verified=$street->street_secret(array(Input::get('address')));
			$flattened=$street->flatten($verified);
			if (!$address->smartyStreet)
	        {
	            $newaddress = new SmartyStreet($flattened[0]);
	            $insert = $address->smartyStreet()->save($newaddress);
			}
	        else
	        {
	        	$smarty=$address->smartyStreet;
	        	$smarty->update($flattened[0]);
	        }
		}
		
		if($updated){
			$message=array('status'=>'success','address'=>array(
			'addressee'=>$address->addressee,
			'email'=>$address->email,
			'address'=>$address->address
			));
		}else{
			$message=array('status'=>'failure');
		}
		return Response::json($message);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /addressapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$address = Addresses::find($id);
		if($address){
			$address->delete();
			$message=array('status'=>'success','id'=>$id,'address'=>$address);
		}else{
			$message=array('status'=>'failure','id'=>$id,'address'=>$address);
		}
		return Response::json($message);
	}

}