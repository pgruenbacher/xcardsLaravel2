<?php
class Orders extends \Eloquent {
	protected $guarded = array('id','reference_number');
	protected $table='orders';
	public function user()
	  {
	    return $this->belongsTo("User");
	  }
  	public function cards(){
  		return $this->belongsTo('Cards');
  	}
}