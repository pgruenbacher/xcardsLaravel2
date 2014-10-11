<?php

class Pets extends \Eloquent {
	protected $guarded = array('id');
	
	public function cards(){
		return $this->hasMany('Cards');
	}
}