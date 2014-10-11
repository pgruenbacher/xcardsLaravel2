<?php namespace XCards\Billing;

interface BillingInterface{
	public function charge(array $data);
}
