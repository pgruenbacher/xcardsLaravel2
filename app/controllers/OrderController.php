<?php
use Gateway;

class OrderController
extends BaseController
{
  public function indexAction()
  {
    $query = Order::with(array(
      "account",
      "orderItems",
      "orderItems.product",
      "orderItems.product.category"
    ));

    $account = Input::get("account");

    if ($account)
    {
      $query->where("account_id", $account);
    }

    return $query->get();
  }
  public function addAction()
	{
	  $validator = Validator::make(Input::all(), array(
	    "account" => "required|exists:users,id",
	    "items"   => "required"
	  ));
	  if ($validator->passes())
	  {
	    $order = Order::create(array(
	      "account_id" => Input::get("account")
	    ));
	
	    try
	    {
	      $items = json_decode(Input::get("items"));
	    }
	    catch (Exception $e)
	    {
	      return Response::json(array(
	        "status" => "error",
	        "errors" => array(
	          "items" => array(
	            "Invalid items format."
	          )
	        )
	      ));
	    }
	
	    $total = 0;
	
	    foreach ($items as $item)
	    {
	      $orderItem = OrderItem::create(array(
	        "order_id"   => $order->id,
	        "product_id" => $item->product_id,
	        "quantity"   => $item->quantity
	      ));
	
	      $product = $orderItem->product;
	
	      $orderItem->price = $product->price;
	      $orderItem->save();
	
	      $product->stock -= $item->quantity; //Subtracts stock from the amount ordered
	      $product->save();
	
	      $total += $orderItem->quantity * $orderItem->price; //Calculates total cost
	    }
	 	$result = $this->gateway->pay(
	      Input::get("number"),
	      Input::get("expiry"),
	      $total,
	      "usd"
	    );
	
	    if (!$result)
	    {
	      return Response::json(array(
	        "status" => "error",
	        "errors" => array(
	          "gateway" => array(
	            "Payment error"
	          )
	        )
	      ));
	    }
	
	    $account = $order->account;
	
	    $document = $this->document->create($order);
	    $this->messenger->send($order, $document);
	
	    return Response::json(array(
	      "status" => "ok",
	      "order"  => $order->toArray()
	    ));
	  }
	
	  return Response::json(array(
	    "status" => "error",
	    "errors" => $validator->errors()->toArray()
	  ));
	}
}