<?php namespace XCards\Providers;

/**
 * 
 */
use Illuminate\Support\ServiceProvider;
class USPSServiceProvider extends ServiceProvider {
	
	function register() {
		$this->app->bind('XCards\USPS\TrackingInterface','XCards\USPS\USPSTrackConfirm');
		$this->app->bind('XCards\USPS\DeliveryCalculatorInterface','XCards\USPS\USPSServiceDeliveryCalculator');
	}
}