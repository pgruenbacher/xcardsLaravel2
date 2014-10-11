<?php

namespace Pgruenbacher\Billing;

interface MessengerInterface
{
  public function send(
    $order,
    $document
  );
}