<?php
class Transfers extends \Eloquent {
	protected $guarded = array('id','recipient_id','giver_id');
	protected $dates = array('created_at','updated_at','deleted_at');
	
	public function recipient(){
		return $this->belongsTo('User','recipient_id');
	}
	public function giver(){
		return $this->belongsTo('User','giver_id');
	}
	public function transfer(){
		if(! $this->confirmed){
			$recipient=$this->recipient()->first();
			$recipient->credits += $this->credits;
			$add=$recipient->save();
			if($add){
				$giver=$this->giver()->first();
				$giver->credits -= $this->credits;
				$sub=$giver->save();
				if($sub){
					$this->confirmed=1;
					$dt=new DateTime;
					$this->confirmed_at=$dt->format('Y-m-d H:i:s');
					$finish=$this->save();
					if($finish){
						return true;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	public function hasRecipient(){
		if(isset($this->recipient()->first()->id)){
			return true;
		}else{
			return false;
		}
	}
	public function revert(){
		if(! $this->confirmed){
			if(isset($this->giver()->first()->id)){
				$giver=$this->giver()->first();
				$giver->credits += $this->credits;
				$giver->save();
				$dt=new DateTime;
				$this->deleted_at=$dt->format('Y-m-d H:i:s');
				if($this->save()){
					return true;
				}
			}
		}
	}
	public function accept(){
		if(! $this->confirmed){
			$recipient=$this->recipient()->first();
			$recipient->credits += $this->credits;
			$recipient->save();
			$this->confirmed=1;
			if($this->save()){
				return true;
			}
		}
	}
	public static function printModal($transfers){
		return View::make('home/transfersModal')->with(array(
			'transfers'=>$transfers,
		))->render();
	}
	public static function boot()
    {
        parent::boot();
        static::deleting(function($transfer)
        {
            $transfer->revert();
        });
    }
}