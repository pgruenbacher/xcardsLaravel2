<?php

namespace Pgruenbacher\Billing;

use Mail;

class EmailMessenger
implements MessengerInterface
{
  public function send(
    $order,
    $document
  )
  {
    Mail::send("email/wrapper", array(), function($message) use ($order, $document)
    {
      $message->subject("Your invoice!");
      $message->from("info@example.com", "Laravel 4 E-Commerce");
      $message->to($order->account->email);

      $message->attach($document, array(
        "as"   => "Invoice " . $order->id,
        "mime" => "application/pdf"
      ));
    });
  }
}