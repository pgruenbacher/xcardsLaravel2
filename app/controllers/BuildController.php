<?php

class BuildController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::check()){
			$id=Auth::user()->id;
		}
		else if(Session::has('user')){
			if(isset(User::find(Session::get('user'))->id)){
				$user=User::find(Session::get('user'));
				$id=$user->id;
			}else{
				$user=new User;
				$user->guest=1;
				$user->save();
				$id=DB::connection('mysql')->getPdo()->lastInsertId();
				Session::put('user',$id);
			}
		}else{
			//Check if user is a guest. If so, make a temporary user profile for saving cards.
			$user=new User;
			$user->guest=1;
			$user->save();
			$id=DB::connection('mysql')->getPdo()->lastInsertId();
			Session::put('user',$id);
		}
		Session::forget('card');
		$card=new Cards;
		$card->user_id=$id;
		if(Session::has('pet')){
			$pet=Pets::find(Session::get('pet'));
			$pet->cards()->save($card);
			Session::forget('pet');
		}else{
			$card->save();
		}				
		$card_id=DB::connection('mysql')->getPdo()->lastInsertId();
		Session::put('card',$card_id);
		Return View::make('build/index');
	}
	
	/*
	 * Process Images
	 */
	public function process(){
		$data=array();
		/*If user is posting, save a new image,
		 * otherwise, use the current sessions card
		 */
		 if(Auth::check()){
		 		$user_id=Auth::user()->id;
		 	}else{
		 		$user_id=Session::get('user');
		 	}
		 if(Input::has('rotate')){
			$id=Input::get('image');
			$image=Images::find($id);
			$imager=Image::make($image['file_path']);
			$imager->rotate(90);
			$quality=90;
			$imager->save($image['file_path'],$quality);
			$dimensions=getimagesize($image['file_path']);
			$image->width=$dimensions[0];
			$image->height=$dimensions[1];
			$image->save();
			$card_id=Session::get('card');
			$card=Cards::find($card_id);
			$data=Images::find($id);
		}elseif(Input::has('src')){
			$url=urldecode(Input::get('src'));
			$image=new Images;
			//saves and copies the image file from instagrams cache
			$id=$image->getImageFile($url);
			//Save thumbnail version of the image
			$image=new Images;
			$thumb_id=$image->saveThumbnail($id);
			$data=Images::find($id);
			$card=Cards::find(Session::get('card'));
			$card->user_id=$user_id;
			$card->cardsetting_id=1;
			$card->original_image=$id;
			$card->thumbnail_image=$thumb_id;
			$card->save();
		}elseif(Session::has('card')){
			$card_id=Session::get('card');
			$card=Cards::find($card_id);
			$original=$card->original_image;
			$data=Images::find($original);
		}
		return View::make('build/process')
		->with(array(
			'image'=>$data,
			'card'=>$card,
			));       
	}
	
	public function crop(){
		$card_id=Session::get('card');
		$card=Cards::find($card_id);
		if(Request::isMethod('post')){
			if(! Input::get('w')>0){
				return Redirect::route('build-process')->with(array('global'=>'You need to crop the photo first!'));
			}
			//Make and crop image
			$rotate=intval(Input::get('rotate'))*-1;
			$format=Input::get('format');
			$id=Input::get('id');
			$w=Input::get('w');
			$h=Input::get('h');
			$x=Input::get('x1');
			$y=Input::get('y1');
			//Save Cropped Image
			$image=new Images;
			$image=$image->saveCroppedRotate($id,$rotate,$w,$h,$x,$y);
			$info=$card->croppedImage()->save($image);
			$crop_id=$info['id'];
			//Create Thumbnail Version
			$image=new Images;
			$thumb_id=$image->saveThumbnail($crop_id);
			//Save Card Record
			$card->cropped_image=$crop_id;
			$card->thumbnail_image=$thumb_id;
			$card->save();
			//Prepare the blade view
			$new_path=Images::find($crop_id)->path;
			$url=URL::asset('assets/images/cropped/'.basename($new_path));
			$back_text=null;
		}elseif(Session::has('card')){
			$card_id=Session::get('card');
			$card=Cards::find($card_id);
			$format=$card->cardsetting_id;
			if($card->back_text==''){
				$back_text=null;
			}else{
				$back_text=$card->back_text;
			}
		}
		if(Request::is('build/edit')){
			$nextRoute='build-send';
		}else if(Request::is('instagram/edit')){
			$nextRoute='instagram-send';
		}
		return View::make('build.card')
		->with(array(
			'card'=>$card,
			'nextRoute'=>$nextRoute,
			'format_id'=>$format,
			'back_text'=>$back_text,
		));
	}
	public function send(){
		$id=Session::get('card');
		$card=Cards::find($id);
		if(Input::has('raw_back_text')){
			//User is posting new text, save it.
			$back_text=Input::get('raw_back_text');
			$card->back_text=$back_text;
			$card->save();
			$selected=null;
		}elseif($card->finished_at > 0){
			//User is re-using a finished card, so replicate
			$new_id=$card->reUse();
			Session::put('card',$new_id);
			$selected=null;
		}
		elseif(Session::has('card')){
			$card_id=Session::get('card');
			$card=Cards::find($card_id);
			$selected=$card->addresses;
		}
		if(Auth::check()){
	 		$user_id=Auth::user()->id;
	 	}else{
	 		$user_id=Session::get('user');				
	 	}
		if(Request::is('build/send')){
			$nextRoute='build-preview';
		}else if(Request::is('instagram/send')){
			$nextRoute='instagram-preview';
		}
		if(isset($card->pet()->first()->name)){
			$pet=$card->pet()->first();
		}else{
			$pet=null;
		}
		$data=Addresses::where('user_id','=',$user_id)->select(array('id','addressee','email','address'))->get();
		return View::make('build.send')->with(array(
		'data'=>$data,
		'selected'=>$selected,
		'nextRoute'=>$nextRoute,
		'pet'=>$pet,
		));
		
	}
	
	public function preview(){
		if(Auth::check()){
			$user=Auth::user();
		}else{
			$user=User::find(Session::get('user'));
		}
		$id=Session::get('card');
		$card=Cards::find($id);
		if(isset($card->pet()->first()->name)){
			$pet=$card->pet()->first();
			$number=1;
		}else{
			$pet=null;
			$number=0;
		}
		if(Request::isMethod('post')){
			$recipients_ids=array();
			if(Input::get('id')!=''){
			$recipients_ids=Input::get('id');
			}
			if(Input::get('addressee')!=''){
			$number=Input::get('number');
			$address_data=Input::all();
			$addresses=new Addresses;
			$ids=$addresses->saveArray($user,$address_data);
			$recipients_ids=array_merge($recipients_ids,$ids);
			}
			if(empty($recipients_ids)&&!isset($card->pet()->first()->name)){
				return Redirect::route('build-send')->with('global','You need to select an address');
			}
			$recipients=Addresses::find($recipients_ids);
			$card->addresses()->sync($recipients);
			$number += count($recipients);
		}
		else if(Request::isMethod('get')){
			$recipients=$card->addresses()->get();
			$number += count($recipients);
		}
		//After saving info, if guest, then send to sign-in
		if(Auth::guest()){
			return Redirect::route('account-sign-in')->with('flash_message','You\'re almost finished, please sign in or create an account to continue');
		}
		$back_text=$card->back_text;
		$img=$card->croppedImage()->first();
		$cardSetting=$card->cardSetting()->first();
		$rate=$cardSetting->credit_rate;
		$net=$number*$rate;
		$pricing=new Pricings;
		$discount= $pricing->calculateDiscount($number);
		$data=array(
			'pet'=>$pet,
			'back_text'=>$back_text,
			'card'=>$card,
			'number'=>$number,
			'current_credits'=>$user->credits,
			'card_type'=>$card->type,
			'recipients'=>$recipients,
			'rate'=>$rate,
			'net'=>$net,
			'cardSetting'=>$cardSetting,
			'discount'=>$discount,
			'user'=>$user,
		);
		return View::make('build.preview')->with($data);
	}
	
	public function finalize(){
		/*
		 * This is for cards paid for by credit, otherwise refer to StripeController
		 */
		 $credits=Input::get('credits');
		$number=Input::get('number');
		$card_id=Session::get('card');
		$card=Cards::find($card_id);
		if($card->finished_at*1 > 0){
			return Redirect::route('home')->with(array(
			'global'=>'you\'ve already sent this card, use the same card to different recipients? <a href="'.URL::route('build-previous').'">Go to Previous Cards</a>',
			));
		}
		
		//Finish Card, save
		$card->finished_at=time();
		$card->save();
		//Remove credits from user
		$user=Auth::user();
		$current_credits=$user->credits;
		$user->credits=$current_credits-$credits;
		$user->save();
		//Create Order record
		$date=date('m-d-Y');
		$reference=str_random(5);
		$order=new Orders;
		$order->reference_number=$reference;
		$order->cards=$number;
		$order->credits=$credits;
		$order->user_id=$user->id;
		$order->cards_id=Session::get('card');
		$order->save();
		//Create Invoice
		$unit_price=$credits/$number;
		$receipt=View::make('credits/credit_receipt')->with(array(
		'reference'=>$reference,
		'user'=>$user,
		'charge'=>$credits,
		'cards'=>$number,
		'date'=>$date,
		'unit_price'=>$unit_price,
		));
		$html=$receipt->render();
		//Send Invoice with pdf attachment
		$pdf=PDF::loadHTML($html);
		$filepath=storage_path('receipts//');
		$filename=$filepath.$reference.'.pdf';
		$savepath=$filename;
		$pdf->save($savepath);
		
		$attachment = chunk_split(base64_encode(file_get_contents($filename))); 
		$mandrill=new Mandrill(Config::get('mandrill.api_key'));
		 $message = array(
	        'html' => $html,
	        'text' => $html,
	        'subject' => 'pre-paid purchase receipt',
	        'from_email' => 'info@x-presscards.com',
	        'from_name' => 'X-Press Cards',
	        'to' => array(
	            array(
	                'email' => $user->email,
	                'name' => $user->username,
	                'type' => 'to'
	            )
	        ),
	    	'preserve_recipients'=>false,
	    	'attachments'=>array(
		    	array(
				 	'type' => 'text/pdf',
	                'name' => $reference.'.pdf',
	                'content' => $attachment,
					)
				)
    		);
		$mandrill->messages->send($message);
		Session::forget('card');
		return Redirect::route('home')->with(array(
		'global'=>"we've sent your cards! You have been charged ".$number." credits"
		));
	}
	
	public function retrieve(){
		$recent_cards=Cards::where('finished_at', '>=', time() - (1*24*60*60))->get();
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
		$pdf->save($file_path.'back_end'.$random.'.pdf');
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