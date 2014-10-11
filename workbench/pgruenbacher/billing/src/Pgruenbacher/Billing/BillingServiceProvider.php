<?php namespace Pgruenbacher\Billing;

use App;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	  {
	    App::bind("billing.stripeGateway", function() {
	      return new StripeGateway();
	    });
	
	    App::bind("billing.pdfDocument", function() {
	      return new PDFDocument();
	    });
	
	    App::bind("billing.emailMessenger", function() {
	      return new EmailMessenger();
	    });
 	 }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
		"billing.stripeGateway",
      	"billing.pdfDocument",
      	"billing.emailMessenger"
	  );
	}

}
