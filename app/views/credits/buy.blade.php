@extends('layout.main')

@section('header')
<meta name="publishable-key" content="{{Config::get('development/stripe.publishable_key')}}"/>
<script src="{{URL::asset('js/transit/transit.min.js')}}"></script>

<style>
	div.cart{
		display:none;
		width:250px;
		height:250px;
		position:fixed;
		border:solid 1px 
		padding:5px;
		left:0px;
		top:100px;
	}
	h2.credits{
		border-bottom:2px dotted;
	}
	h4.price{
		border-bottom:1px dotted;
	}
</style>
@stop
@section('billing')
<h1>Buy Credits</h1>
<h2>Your current credits: {{$current_credits}}</h2>
<p>We accept Visa, Mastercard, American Express, JCB, Discover, and Diners Club</p>
<div class="row">
@foreach($price_data as $price)
	<div class="col-md-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				{{$price['amount']}} Credits
			</div>
			<div class="panel-body">
				<p>${{$price['price']}}</p>
				<p>Gets you {{$price['amount']}} credits</p>
				<p>Equivalent to {{$price['standard_cards']}} cards</p>
				<button data-button='{"price_id":{{$price['id']}}, "cards":{{$price['standard_cards']}},"price":{{$price['price']}}, "credits":{{$price['amount']}} }' class="btn btn-info credits">
					Add to Cart
				<icon class="fa fa-shopping-cart"></icon></button>
			</div>
		</div>
	</div>
@endforeach	
</div>
<div id="cart" class="cart panel panel-info">
	<div class="panel-heading">
		<h3>Shopping Cart <i class="fa fa-credit-card"></i></h3>
	</div>
	<div class="panel-body">
		<h2 class="credits"></h2>
		<h4 class="price"></h4>
		<form class="StripeCheckoutForm" action="{{URL::to('buy')}}" method="post">
			<button id="StripeCheckout" class="btn btn-info">Check Out</button>
			{{Form::token()}}
			<input type="hidden" name="email" value="{{Auth::user()->email}}" />
			<input id="amount" type="hidden" name="amount" value="" />
			<input id="credits" type="hidden" name="credits" value="" />
			<input id="price_id" type="hidden" name="price_id" value=""/>
		</form>
	</div>
</div>
@stop

@section('footer')
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
var submitbutton=document.getElementById('StripeCheckout');
var creditoption=$('button.credits').click(function(event){
	var target=event.target|| event.srcElement;
	var data = $.parseJSON($(this).attr('data-button'));
	$('#cart').show();
	var distance = $(window).width()-$('#cart').width();
	console.log(data);
	$('#cart').transition({x:distance},500,'ease');
	$('h2.credits').html(data.credits+' credits');
	$('h4.price').html('total: $'+data.price)
	$('#amount').val(data.price*100);
	$('#credits').val(data.credits);
	$('#price_id').val(data.price_id);
	$('#StripeCheckout').html('Checkout ($'+data.price+')')
});


var submitbutton=document.getElementById('StripeCheckout');
var credits=$('#credits').val();
var amount=$('#amount').val();
var handler = StripeCheckout.configure({
    key: '{{Config::get('development/stripe.publishable_key')}}',
    image: '{{URL::asset('assets/images/XPress_Cards.png')}}',
    token: function(token, args) {
       var $input = $('<input type=hidden name=stripe-token />').val(token.id);
        $('form.StripeCheckoutForm').append($input).submit();
    } //End Token Function
  });

  submitbutton.addEventListener('click', function(e) {
    // Open Checkout with further options
    var amount=$('#amount').val();
    console.log(amount);
    handler.open({
      name: 'XPress Cards',
      description: credits+' Credits',
      amount: amount,
      email: '{{Auth::user()->email}}'
    });
    e.preventDefault();
  });
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script src="{{asset('js/billing.js')}}"></script>
@stop