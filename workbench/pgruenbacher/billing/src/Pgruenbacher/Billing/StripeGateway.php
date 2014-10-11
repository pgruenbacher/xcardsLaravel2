<?php

namespace Pgruenbacher\Billing;

use Stripe;
use Stripe_Charge;

class StripeGateway
implements GatewayInterface
{
  public function pay(
    $number,
    $expiry,
    $amount,
    $currency
  )
  {
    Stripe::setApiKey("sk_test_QLCwJNGWSKjOVqb4HEY1h359");

    $expiry = explode("/", $expiry);

    try
    {
      $charge = Stripe_Charge::create(array(
        "card" => array(
          "number"    => $number,
          "exp_month" => $expiry[0],
          "exp_year"  => $expiry[1]
        ),
        "amount"   => round($amount * 100),
        "currency" => $currency
      ));
      
      return true;  
    }
    catch (Exception $e)
    {
      return false; 
    }
  }
}