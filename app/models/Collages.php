<?php

class Collages extends \Eloquent {
	protected $guarded='id';
	
	public function renderPDF($width,$height){
		return View::make('collage/collagePDF')->with(array(
			'orientation'=>$this->orientation,
			'image1'=>$this->image(1),
			'image2'=>$this->image(2),
			'image3'=>$this->image(3),
			'image4'=>$this->image(4),
			'image5'=>$this->image(5),
			'image6'=>$this->image(6),
			'width'=>$width,
			'height'=>$height,
		))->render();
	}
	public function renderCollage(){
		return View::make('collage/collage')->with(array(
			'orientation'=>$this->orientation,
			'image1'=>$this->image(1),
			'image2'=>$this->image(2),
			'image3'=>$this->image(3),
			'image4'=>$this->image(4),
			'image5'=>$this->image(5),
			'image6'=>$this->image(6),
		))->render();
	}
	public function renderThumb(){
		return View::make('collage/collageThumb')->with(array(
			'orientation'=>$this->orientation,
			'image1'=>$this->thumb(1),
			'image2'=>$this->thumb(2),
			'image3'=>$this->thumb(3),
			'image4'=>$this->thumb(4),
			'image5'=>$this->thumb(5),
			'image6'=>$this->thumb(6),
		))->render();
	}
	public function images(){
		return $this->hasMany('Images','id','image1')
		->orWhere('id','=',$this->image2)
		->orWhere('id','=',$this->image3)
		->orWhere('id','=',$this->image4)
		->orWhere('id','=',$this->image5)
		->orWhere('id','=',$this->image6);
	}
	public function image($number=1){
		$string='image'.$number;
		return Images::find($this->$string);
	}
	public function thumb($number=1){
		$string='image'.$number;
		return Images::find($this->$string)->children()->first();
	}
	public function card(){
		return $this->belongsTo('Cards');
	}
	public static function boot(){
	 	parent::boot();
		static::deleting(function($collage) { // before delete() method call this
             $images=$collage->images()->get();
			$images->each(function($image){
				$image->delete();
			});
	 	});
	}	
}