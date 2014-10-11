<?php

class CardSettings extends \Eloquent {
	protected $guarded = array('id','credit_rate');
	protected $table='cardsettings';
}