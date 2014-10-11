<?php
namespace XCards\Billing;

use Stripe;
use Stripe_Charge;
use Stripe_Customer;
use Stripe_InvalidRequestError;
use Stripe_CardError;
use Config;
use Exception;

class StripeBilling implements BillingInterface {

    public function __construct()
    {
        Stripe::setApiKey(Config::get('development/stripe.secret_key'));
    }

    public function charge(array $data)
    {
   	  try
        {
            $customer = Stripe_Customer::create(array(
                'card' => $data['token'],
                'description' => $data['email']
            ));

            Stripe_Charge::create(array(
                'customer' => $customer->id,
                'amount' => $data['amount'], // $10
                'currency' => 'usd'
            ));

            return $customer->id;
        }

        catch (Stripe_InvalidRequestError $e)
        {
            // Invalid parameters were supplied to Stripe's API
            throw new Exception($e->getMessage());
        }

        catch(Stripe_CardError $e)
        {
            throw new Exception($e->getMessage());
        }
    }
}