<?php

class AdminController extends \BaseController {
	/*
	 * Called by admin page
	 */
	public function download(){
		$input=Input::all();
		$rules=array(
		'start'=>'before:end',
		'end'=>'after:start',
		);
		$validator=Validator::make($input,$rules);
		if($validator->fails()){
			return Redirect::to('admin');
		}
		$start=strtotime(Input::get('start'));
		$end=strtotime(Input::get('end'));
		$recent_cards=Cards::where('finished_at', '>=', $start)->where('finished_at','<=',$end)->get();
		if(! $recent_cards->count()){
			return 'no cards, change parameters';
		}
		$number=0;
		$i=0;
		foreach($recent_cards as $recent_card){
			$number+=$recent_card->Addresses()->count();
			$addresses=$recent_card->Addresses()->get();
			$data[$i]=$recent_card;
			$data[$i]['addresses']=$addresses;
			$j=0;
			foreach($addresses as $address){
				$smarty=$address->smartyStreet()->get();
				$data[$i]['addresses'][$j]['smarty']=$smarty;
				$j++;
			}
			$i++;
		}
		$iter=intval($number/9+1);
		$remainder=$number%9;
		$data=array(
		'cards'=>$recent_cards,
		'iterations'=>$iter,
		'remainder'=>$remainder,
		);
		$html=View::make('build.sendpdf3')
		->with($data);
		$size=array(0,0,1368,936);
		//return $html;
		//if necessary
		set_time_limit(30);
		PDF::setPaper($size);
		$pdf=PDF::loadView('build.sendpdf3',$data);
		//Save PDF in server.
		$year=date('Y');
		$month=date('m');
		$day=date('d');
		$random=str_random(5);
		$file_path=storage_path('pdf/'.$year.'_'.$month.'_'.$day.'_');
		return $pdf->download('back_end'.$random.'.pdf');
	}
	/**
	 * Display a listing of the resource.
	 * GET /admin
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /admin/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /admin
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /admin/{id}
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
	 * GET /admin/{id}/edit
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
	 * PUT /admin/{id}
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
	 * DELETE /admin/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}