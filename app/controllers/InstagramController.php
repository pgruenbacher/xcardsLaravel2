<?php

class InstagramController extends BaseController{
	
	public function index(){
		$instagram=new Instagram(array(
		  'apiKey'      => '490194c0ac12434bba4337d5dda21df4',
	      'apiSecret'   => '05bad7ab23e84d149f691957be4e5cc7',
	      'apiCallback' => 'http://paulgruenbacher.com/xcards/instagram'
		));
		if(Auth::check()){
			$user=Auth::user();
		}else{
			$user=User::find(Session::get('user'));
		}
		if(Input::has('code')){
			$code=Input::get('code');
		}
		$data=array();
		if(isset($user->instagram_id)){
			$id=$user->instagram_id;
			$token=$user->instagram_token;
		}else{
			$id=null;
			$token=null;
		}
		if(isset($token,$id)){
			$instagram->setAccessToken($token);
			$media=$instagram->getUserMedia($id,6);
			
		}			
		elseif(isset($code)){
			$data = $instagram->getOAuthToken($code);
			$id=$data->user->id;
			$check=$instagram->setAccessToken($data);
			$media=$instagram->getUserMedia($id,6);
			$user->instagram_token=$instagram->getAccessToken();
			$user->instagram_id=$id;
			$user->save();		
		}
		else {
			$media=null;
			$data=null;
		}
		$view_data=array('instagram'=>$instagram,'media'=>$media,'id'=>$id);
		return View::make('instagram/instagram-collage',$view_data);
	}
	public function process(){
		$validator=Validator::make(Input::all(),
		array( 
			'image1'=>'required',
			'image2'=>'required',
			'image3'=>'required',
			'image4'=>'required',
			'image5'=>'required',
			'image6'=>'required',
			'orientation'=>'required'
			)
		);
		if($validator->fails()){
			return Redirect::route('instagram')
			->withErrors($validator)
			->withInput();
		}
		else{
			$imager=new Images;
			$image1=Images::find($imager->getImageFile(Input::get('image1')));
			$i1T=new Images;
			$i1T->saveThumbnail($image1['id']);
			$imager=new Images;
			$image2=Images::find($imager->getImageFile(Input::get('image2')));
			$i2T=new Images;
			$i2T->saveThumbnail($image2['id']);
			$imager=new Images;
			$image3=Images::find($imager->getImageFile(Input::get('image3')));
			$i3T=new Images;
			$i3T->saveThumbnail($image3['id']);
			$imager=new Images;
			$image4=Images::find($imager->getImageFile(Input::get('image4')));
			$i4T=new Images;
			$i4T->saveThumbnail($image4['id']);
			$imager=new Images;
			$image5=Images::find($imager->getImageFile(Input::get('image5')));
			$i5T=new Images;
			$i5T->saveThumbnail($image5['id']);
			$imager=new Images;
			$image6=Images::find($imager->getImageFile(Input::get('image6')));
			$i6T=new Images;
			$i6T->saveThumbnail($image6['id']);
			//Create new Collage
			$collage=new Collages;
			$collage->image1=$image1['id'];
			$collage->image2=$image2['id'];
			$collage->image3=$image3['id'];
			$collage->image4=$image4['id'];
			$collage->image5=$image5['id'];
			$collage->image6=$image6['id'];
			$collage->orientation=Input::get('orientation');
			if(Input::has('image1offsetx')){
				$input=Input::all();
				$collage->image1offsetx=$input['image1offsetx'];
				$collage->image1offsety=$input['image1offsety'];
				$collage->image2offsetx=$input['image2offsetx'];
				$collage->image2offsety=$input['image2offsety'];
				$collage->image3offsetx=$input['image3offsetx'];
				$collage->image3offsety=$input['image3offsety'];
				$collage->image4offsetx=$input['image4offsetx'];
				$collage->image4offsety=$input['image4offsety'];
				$collage->image5offsetx=$input['image5offsetx'];
				$collage->image5offsety=$input['image5offsety'];
				$collage->image6offsetx=$input['image6offsetx'];
				$collage->image6offsety=$input['image6offsety'];
			}
			if(Session::has('card')){
				$card=Cards::find(Session::get('card'));
				$id=$card->id;
			}else{
				$card=new Cards;
				$new=true;
			}
			$card->cardsetting_id=3;
			 if(Auth::check()){
		 		$user_id=Auth::user()->id;
		 	}else{
		 		$user_id=Session::get('user');
		 	}
			$card->cardsetting_id=3;
			$card->user_id=$user_id;
			$card->save();
			if(isset($new)){
				$id=DB::connection('mysql')->getPdo()->lastInsertId();
			}
			$card->collage()->save($collage);
			Session::put('card',$id);
			return Redirect::route('instagram-edit');
		}
	}	
	
}
