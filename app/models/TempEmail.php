<?php

class TempEmail extends Eloquent {
	protected $table="tempemails";
	protected $guarded=array('id');
	protected $softdelete=false;
	
	public function users(){
		return $this->belongsTo("users");
	}
	
}