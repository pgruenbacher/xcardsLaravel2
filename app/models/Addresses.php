<?php

class Addresses extends Eloquent {
	protected $table="addresses";
	protected $guarded=array('id');
	protected $softdelete=true;
	
	public function smartyStreet(){
		return $this->hasOne("SmartyStreet","addresses_id");
	}
	public function user(){
		return $this->belongsTo("User","user_id");
	}
	public function Cards(){
		return $this->belongsToMany("Cards");
	}
	public function copyTo($user_id){
		$id=$this->id;
		$smarty_id=Addresses::find($id)->smartyStreet->id;
		$address=Addresses::find($id)->replicate();
		$address->user_id=$user_id;
		$address->save();
		$new_id=DB::connection('mysql')->getPdo()->lastInsertId();
		$smarty=SmartyStreet::find($smarty_id)->replicate();
		$smarty->addresses_id=$new_id;
		$smarty->save();
	}
	public function saveArray($user,$address_data){
		$rows=$address_data['address'];
		$data=array();
		$ids=array();
		$i=0;
		$new_date = date('Y-m-d');
		$street=new SmartyStreet;
		$verified=$street->street_secret($rows);
		$flattened=$street->flatten($verified);
		foreach($rows as $row){
			$data=array(
			'user_id'=>$user->id,
			'addressee'=>$address_data['addressee'][$i],
			'email'=>$address_data['email'][$i],
			'address'=>$row,
			'created_at'=>$new_date
			);
			Addresses::insert($data);
			$ids[$i]=DB::connection('mysql')->getPdo()->lastInsertId();
			$address=Addresses::find($ids[$i]);
			if(isset($flattened[$i])){
				$smarty_street=new SmartyStreet($flattened[$i]);
				$smarty_street=$address->smartyStreet()->save($smarty_street);
			}
			$i++;
		}
		
		return $ids;
	}
	 protected static function boot(){
	 	parent::boot();
		static::deleting(function($address) { // before delete() method call this
             $user->smartyStreet()->first()->delete();
        });
	 }
	
}