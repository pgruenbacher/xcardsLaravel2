<?php
// Alias Editor classes so they are easy to use
use
    DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Join,
    DataTables\Editor\Validate;

class AddressesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	$user=Auth::user();
	$addresses=$user->addresses()->take(10)->get();
	return View::make('addresses.index')
	->with('addresses',$addresses);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function editor(){
		// Build our Editor instance and process the data coming from _POST
		Editor::inst( $db, 'browsers' )
		    ->fields(
		        Field::inst( 'addressee' )->validator( 'Validate::required' ),
		        Field::inst( 'email' )->validator( 'Validate::required' ),
		        Field::inst( 'address' )
	        	)
		    ->process( $_POST )
		    ->json();
	}
	public function data()
	{
		$user_id=Auth::user()->id;
		$actions=Input::get('actions');
		if($actions=='select'){
			$data=Addresses::where('user_id','=',$user_id)->select(array('id','addressee','email','address'));
			return Datatables::of($data)
				->add_column('select',
				'<div class="checkbox">
        			<label>
          			<input type="checkbox">
        			</label>
      			</div>')
				->remove_column('id')
	            ->make();
		}
		$data=Addresses::where('user_id','=',$user_id)->select(array('id','addressee','email','address'));
		return Datatables::of($data)
			->add_column('actions','<a class="btn btn-default" href="{{ URL::route(\'address-book.edit\', array($id)) }}"><i class="fa fa-pencil"></i> edit</a>
			<form class="pull-right" accept-charset="UTF-8" action="{{URL::route(\'address-book.destroy\',$id)}}" method="POST">
			    {{Form::token()}}
			    <input type="hidden" value="DELETE" name="_method"></input>
			    <button class="btn btn-default" type="submit"><i class="fa fa-times"> Delete</i></button>
			</form>
				
        	')->remove_column('id')
            ->make();
	}
	
	 
	public function create()
	{
		//Load the Address Create Form
		return View::make('addresses.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	$address_data=Input::all();
	$user=Auth::user();
	$addresses=new Addresses;
	$addresses->saveArray($user,$address_data);	 
	Session::flash('message','succesfully added addresses');
	return Redirect::route('address-book.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Get address
		$address=Addresses::find($id);
		Return View::make('addresses.show')
		->with('address',$address);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the address
		$address = Addresses::find($id);

		// show the edit form and pass the address
		return View::make('addresses.edit')
			->with('address', $address);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'addressee'       => 'required',
			'email'      => 'email',	
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('address-book/' . $id . '/edit')
				->withErrors($validator)
				->withInput();
		} else {
			// store
			$address = Addresses::find($id);
			$address->addressee = Input::get('addressee');
			$address->email   = Input::get('email');
			$address->address = Input::get('address');
			$address->save();
						
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
			// redirect
			Session::flash('message', 'Successfully updated address!');
			return Redirect::route('address-book.index');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$address = Addresses::find($id);
		$address->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the address');
		return Redirect::route('address-book.index');
	}
	

}