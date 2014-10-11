<?php namespace XCards\Providers;

/**
 * 
 */
use Illuminate\Support\ServiceProvider;
class BillingServiceProvider extends ServiceProvider {
	
	function register() {
		$this->app->bind('XCards\Billing\BillingInterface','XCards\Billing\StripeBilling');
	}
}
