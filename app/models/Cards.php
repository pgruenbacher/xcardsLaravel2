<?php

class Cards extends \Eloquent {
	protected $guarded = array('id');
	protected $table='cards';
	public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
	public function collage(){
		return $this->hasOne('Collages')->orderBy('updated_at','desc');
	}
	public function croppedImage(){
		return $this->hasOne('Images','cards_id');
	}
	public function cardSetting(){
		return $this->belongsTo('CardSettings','cardsetting_id');
	}
	public function pet(){
		return $this->belongsTo('Pets','pets_id');
	}
	public function addresses(){
		return $this->belongsToMany('Addresses');
	}
	public function thumbnail(){
		$id=$this->thumbnail_image;
		return Images::find($id);
	}
	public static function renderPreviewBanner(){
		if(Session::has('card'));
		$card=Cards::find(Session::get('card'));
		$directions='Directions directions';
		return View::make('build/previewBanner')
		->with(array(
			'card'=>$card,
			'directions'=>$directions,
		))->render();
	}
	public function orders(){
		return $this->hasMany('Orders');
	}
	public function nextRoute(){
		if($this->hasType('collage')){
			if(! isset($this->cardSetting()->first()->type)){
				return 'build-index';
			}
			else if($this->back_text==null){
				return 'instagram-edit';
			}else if($this->addresses()->first()==null){
				return 'instagram-send';
			}else if($this->finished_at > 0){
				return 'instagram-send';
			}else{
				return 'instagram-preview';
			}
		}
		if(! isset($this->cardSetting()->first()->type)){
			return 'build-index';
		}
		else if($this->cropped_image==0){
			return 'build-process';
		}else if($this->back_text==null){
			return 'build-crop';
		}else if($this->addresses()->first()==null){
			return 'build-send';
		}else if($this->finished_at > 0){
			return 'build-send';
		}else{
			return 'build-preview';
		}
	}
	public function reUse(){
		$id=$this->id;
		$image_id=Cards::find($id)->croppedImage->id;
		$card=Cards::find($id)->replicate();
		$card->finished_at=0;
		$card->save();
		$new_id=DB::connection('mysql')->getPdo()->lastInsertId();
		$image=Images::find($image_id)->replicate();
		$image->cards_id=$new_id;
		$image->save();	
		return $new_id;
	}
	public function hasType($type=null){
		if($type){
			if(isset($this->cardSetting()->first()->type)){
				return $this->cardSetting()->first()->type == $type;
			}else{
				return false;
			}
		}else{
			if(isset($this->cardSetting()->first()->type)){
				return $this->cardSetting()->first()->type;
			}else{
				return false;
			}
		}
		
	}
	public function renderBackSideSmall(){
		Return '<img width="100%" src="'.URL::asset('assets/images/XpressCardsBlankSmall.jpg').'"/>';
	}
	public function renderImage(){
		if($this->hasType('collage')){
			Return $this->collage()->first()->renderCollage();
		}else if($this->hasType('6x4')){
			$src=$this->croppedImage->path;
			Return '<img width="100%" src="'.$src.'"/>';
		}
	}
	public function renderPDF($width,$height){
		if($this->hasType('collage')){
			Return $this->collage()->first()->renderPDF($width,$height);
		}else if($this->hasType('6x4')){
			$src=$this->croppedImage->path;
			Return '<img width="100%" src="'.$src.'"/>';
		}
	}
	public function renderThumbnail(){
		if($this->hasType('collage')){
			Return $this->collage()->first()->renderThumb();
		}else if($this->hasType('6x4')){
			$src=$this->thumbnail()->path;
			Return '<img width="100%" src="'.$src.'"/>';
		}
	}
	public static function boot(){
	 	parent::boot();
		static::deleting(function($card) { // before delete() method call this
             if($card->hasType('collage')){
             	$card->collage()->first()->delete();
             }else if($card->hasType('6x4')){
             	$card->croppedImage()->first()->delete();
				$card->thumbnail()->first()->delete();
             }
        });
	 }
 
}