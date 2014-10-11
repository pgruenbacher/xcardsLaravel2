<?php namespace XCards\Providers;

/**
 * 
 */
use Illuminate\Support\ServiceProvider;
class CloudSpongeServiceProvider extends ServiceProvider {
	
	function register() {
		$this->app->bind('XCards\CloudSponge\CloudSpongeInterface','XCards\CloudSponge\CloudSponge');
	}
}
