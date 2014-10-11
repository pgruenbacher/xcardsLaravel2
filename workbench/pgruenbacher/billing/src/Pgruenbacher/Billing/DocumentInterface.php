<?php

namespace Pgruenbacher\Billing;

interface DocumentInterface
{
  public function create($order);
}