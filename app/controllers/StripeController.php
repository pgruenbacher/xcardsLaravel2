<?php

class StripeController extends \BaseController {

	public function charge(){
		$billing=App::make('XCards\Billing\BillingInterface');
		$error=null;
		$charged=Input::get('amount');
		$credits=Input::get('credits');
		$price_id=Input::get('price_id');
		$actual_charge=Pricings::find($price_id);
			if($actual_charge->price*100==$charged && $actual_charge->amount==$credits){
				//good no tampering
			}else{
				$error='There was an error with our pricing system, try again later';
			}
			try{
				$customerId= $billing->charge(array(
						'email'=>Input::get('email'),
						'token'=>Input::get('stripe-token'),
						'amount'=>Input::get('amount')
					));
				$user = Auth::user();
				$user->billing_id = $customerId;
			    $user->save();
			}
			
			catch(Stripe_CardError $e)
		       {
		           $body = $e->getJsonBody();
		           $err = $body['error'];
		           Log::write('error', 'Stripe: ' . $err['type'] . ': ' . $err['code'] . ': ' . $err['message']);
		           $error = $err['message'];
		       }
	       	catch (Stripe_InvalidRequestError $e)
		       {
		           $body = $e->getJsonBody();
		           $err = $body['error'];
		           Log::write('error', 'Stripe: ' . $err['type'] . ': ' . $err['message']);
		           $error = $err['message'];
		       }
	       catch (Stripe_ApiConnectionError $e)
		       {
		         // Network communication with Stripe failed
		           $error = 'A network error occurred.';
		       }
	       catch (Stripe_AuthenticationError $e)
		       {
		           Log::write('error','Stripe: API key rejected!', 'stripe');
		           $error = 'Payment processor API key error.';
		       }
	       catch (Stripe_Error $e)
	       	{
	           Log::write('error', 'Stripe: Stripe_Error - Stripe could be down.');
	           $error = 'Payment processor error, try again later.';
	 		}
	       catch (Exception $e)
	       	{
	           Log::write('error', 'Stripe: Unknown error.');
	           $error = 'There was an error, try again later.';
	       	}
		    if($error !== null)
		    {
		        return Redirect::refresh()->withFlashMessage($error);
		    }
			else{
				$current_credits=$user->credits;
				$user->credits=$current_credits+$credits;
				$user->save();
				
				$unit_price=$charged/$credits/100;
				$unit_price=number_format((float)$unit_price, 2, '.', '');
				$deci_charge=number_format((float)$charged/100,2,'.','');				
				$date=date('m-d-Y');
				$reference=str_random(5);
				$order=new Orders;
				$order->reference_number=$reference;
				$order->credits=$credits;
				$order->charge=$charged;
				$order->user_id=$user->id;
				$order->pricing_id=$price_id;
				$order->save();
				
				$receipt=View::make('credits.receipt')->with(array(
				'reference'=>$reference,
				'user'=>$user,
				'charge'=>$deci_charge,
				'credits'=>$credits,
				'date'=>$date,
				'unit_price'=>$unit_price,
				));
				$html=$receipt->render();
				
				$pdf=PDF::loadHTML($html);
				$filepath=storage_path('receipts//');
				$filename=$filepath.$reference.'.pdf';
				$savepath=$filename;
				$pdf->save($savepath);
				
				$attachment = chunk_split(base64_encode(file_get_contents($filename))); 
				$mandrill=new Mandrill(Config::get('mandrill.api_key'));
				 $message = array(
			        'html' => $html,
			        'text' => $html,
			        'subject' => 'credit receipt',
			        'from_email' => 'info@x-presscards.com',
			        'from_name' => 'X-Press Cards',
			        'to' => array(
			            array(
			                'email' => $user->email,
			                'name' => $user->username,
			                'type' => 'to'
			            )
			        ),
			    	'preserve_recipients'=>false,
			    	'attachments'=>array(
				    	array(
						 	'type' => 'text/pdf',
			                'name' => $reference.'.pdf',
			                'content' => $attachment,
							)
						)
		    		);
				$mandrill->messages->send($message);
												
				return Redirect::route('home')->with('global','You have been charged succesfully, a receipt has been sent to your email address');
			}
		    
	}
	public function index(){
		$array=array(1,2,3,4);
		$price_data=Pricings::find($array);
		$current_credits=Auth::user()->credits;
				
		Return View::make('credits.buy')->with(array(
			'price_data'=>$price_data,
			'current_credits'=>$current_credits
		));
	}
	
	public function purchase(){
		$card=Cards::find(Session::get('card'));
		if($card->finished_at*1 > 0){
			return Redirect::route('home')->with(array(
			'global'=>'you\'ve already sent this card, use the same card to different recipients? <a href="'.URL::route('build-previous').'">Go to Previous Cards</a>',
			));
		}
		$billing=App::make('XCards\Billing\BillingInterface');
		$error=null;
		$charged=Input::get('amount');
		$number=Input::get('number');
			try{
				$customerId= $billing->charge(array(
						'email'=>Input::get('email'),
						'token'=>Input::get('stripe-token'),
						'amount'=>Input::get('amount')
					));
				$user = Auth::user();
				$user->billing_id = $customerId;
			    $user->save();
			}
			
			catch(Stripe_CardError $e)
		       {
		           $body = $e->getJsonBody();
		           $err = $body['error'];
		           Log::write('error', 'Stripe: ' . $err['type'] . ': ' . $err['code'] . ': ' . $err['message']);
		           $error = $err['message'];
		       }
	       	catch (Stripe_InvalidRequestError $e)
		       {
		           $body = $e->getJsonBody();
		           $err = $body['error'];
		           Log::write('error', 'Stripe: ' . $err['type'] . ': ' . $err['message']);
		           $error = $err['message'];
		       }
	       catch (Stripe_ApiConnectionError $e)
		       {
		         // Network communication with Stripe failed
		           $error = 'A network error occurred.';
		       }
	       catch (Stripe_AuthenticationError $e)
		       {
		           Log::write('error','Stripe: API key rejected!', 'stripe');
		           $error = 'Payment processor API key error.';
		       }
	       catch (Stripe_Error $e)
	       	{
	           Log::write('error', 'Stripe: Stripe_Error - Stripe could be down.');
	           $error = 'Payment processor error, try again later.';
	 		}
	       catch (Exception $e)
	       	{
	           Log::write('error', 'Stripe: Unknown error.');
	           $error = 'There was an error, try again later.';
	       	}
		    if($error !== null)
		    {
		        return Redirect::refresh()->withFlashMessage($error);
		    }
			else{
				$unit_price=$charged/$number/100;
				$unit_price=number_format((float)$unit_price, 2, '.', '');
				$deci_charge=number_format((float)$charged/100,2,'.','');				
				$date=date('m-d-Y');
				$reference=str_random(5);
				$order=new Orders;
				$order->reference_number=$reference;
				$order->cards=$number;
				$order->charge=$charged;
				$order->user_id=$user->id;
				$order->cards_id=Session::get('card');
				$order->save();
				
				$receipt=View::make('credits/card_receipt')->with(array(
				'reference'=>$reference,
				'user'=>$user,
				'charge'=>$deci_charge,
				'cards'=>$number,
				'date'=>$date,
				'unit_price'=>$unit_price,
				));
				$html=$receipt->render();
				
				$pdf=PDF::loadHTML($html);
				$filepath=storage_path('receipts//');
				$filename=$filepath.$reference.'.pdf';
				$savepath=$filename;
				$pdf->save($savepath);
				
				$attachment = chunk_split(base64_encode(file_get_contents($filename))); 
				$mandrill=new Mandrill(Config::get('mandrill.api_key'));
				 $message = array(
			        'html' => $html,
			        'text' => $html,
			        'subject' => 'credit receipt',
			        'from_email' => 'info@x-presscards.com',
			        'from_name' => 'X-Press Cards',
			        'to' => array(
			            array(
			                'email' => $user->email,
			                'name' => $user->username,
			                'type' => 'to'
			            )
			        ),
			    	'preserve_recipients'=>false,
			    	'attachments'=>array(
				    	array(
						 	'type' => 'text/pdf',
			                'name' => $reference.'.pdf',
			                'content' => $attachment,
							)
						)
		    		);
				$mandrill->messages->send($message);
				$card->finished_at=time();
				$card->save();
				Session::forget('card');								
				return Redirect::route('home')->with('global','You have been charged succesfully, a receipt has been sent to your email address');
			}
	}

}