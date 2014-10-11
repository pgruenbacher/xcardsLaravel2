<?php

namespace Pgruenbacher\Billing;

interface GatewayInterface
{
  public function pay(
    $number,
    $expiry,
    $amount,
    $currency
  );
}