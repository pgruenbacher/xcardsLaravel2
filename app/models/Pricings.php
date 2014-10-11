<?php

class Pricings extends \Eloquent {
	protected $guarded = array('id','price','amount');
	protected $table = 'pricings';
	
	public function calculateDiscount($number){
		$discounts=$this->select('discount','amount')->get();
		foreach($discounts as $discount){
			if($number >= $discount['amount']){
				return $discount['discount'];
			}
		}
		
	}
}