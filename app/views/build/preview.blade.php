@extends('layout.main')
@section('banner-title')
Preview
@stop
@section('banner-instructions')
Verify your addresses, image, and message
@stop
@section('header')
@if($current_credits < $net)
	<meta name="publishable-key" content="{{Config::get('development/stripe.publishable_key')}}"/>
	<script src="{{URL::asset('js/transit/transit.min.js')}}"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
@endif
<script src="{{URL::asset('js/jquery.quickflip.min.js')}}" type="text/javascript"></script>
<style>
	#address-book-head{margin-bottom:0px;}
	#finalize{
		z-index: 30;
	}
	.quickflip-wrapper{
		position:relative;
		width:900px;
		height:600px;
	}
	button.quickFlipCta{
		position:absolute;
		left:45%;
	}
	div.image-card{
		position:relative;
		z-index: -10;
		width:100%;
		height:100%;
		border:1px solid;
	}
	div.image-card>img{
		width:100%;
	}
	div.back_text{
		top:30px;
		left:25px;
		width:410px;
		position:absolute;
		z-index: 10;
	}
	div.back_text{
		font-size:14pt;
	}
	div.report{
		
	}
	p.arithmetic{
		border-bottom:1px dotted;
	}
	p.split{
		display: block;
	}
	p.split span{
		display:block;
		float:right;
	}
	p.discount span{
		color:red;
	}
	.img-small{
		max-height:200px;
	}
	div.scrollable { max-height: 250px; width: 100%; margin: 0; overflow-y: auto; }
	.table-scrollable { margin: 0; padding: 0; }
</style>
@stop
@section('addresses')
<div class="row">
	@if(! $pet)
	<div class="col-md-8">
		<div class="recipientTable">
			<table id="address-book-head" class="table table-striped table-condensed">
				<thead>
					<tr>
						<th>Recipient</th>
						<th>Address</th>
						<th>Est Delivery Time</th>
					</tr>
				</thead>
			</table>
			<div class="scrollable">
				<table class="table table-striped table-condensed table-scrollable">
					<tbody>
						@foreach($recipients as $recipient)
						<tr>
							<td>{{$recipient->addressee}}</td>
							<td>{{$recipient->address}}</td>
							<td>{{$recipient->smartyStreet['county_fips']}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@else
	<div class="col-md-8">
		<h2>You're sending a card to: {{$pet->name}}<small>He'll send one back to you!</small></h2>
		<img class="img-responsive img-small img-circle" src="{{URL::asset('assets/images/'.$pet->image)}}"/>
	</div>
	@endif
	<div class="col-md-4">
		@if($current_credits > $net)
			<div class="report panel panel-info">
				<div class="panel-heading">
					<p>Tentative Report</p>
				</div>
				<div class="panel-body">
					<p class="split">Your Current Credits:<span>{{$current_credits}}</span></p>
					<p class="split">{{$number}} cards to be sent <span>{{$number}}</span></p>
					<p class="arithmetic split">At {{$rate}} credit(s) per card:<span>- {{$net}}</span></p>
					<p class="split">Credits left: <span>{{$current_credits-$net}}</span></p>
				</div>
			</div>
			{{Form::open(array('route'=>'build-final'))}}
			<input type="hidden" name="number" value="{{$number}}">
			<input type="hidden" name="credits" value="{{$net}}">
			<button id="finalize" class="btn">Send!</button>
			{{Form::close()}}
		@else
			<div class="report panel panel-info">
				<div class="panel-heading">
					<p>Tentative Report</p>
				</div>
				<div class="panel-body">
					<p class="split">Your Current Credits:<span>{{$current_credits}}</span></p>
					<p><a href="{{URL::route('buy-credits')}}">Buy bulk credits</a></p>
					<p class="split">{{$number}} cards to be sent <span>{{$number}}</span></p>
					<p class="split">At {{$dollar_rate=$cardSetting->dollar_rate}} dollars per card:<span>${{$net=$number*$dollar_rate}}</span></p>
					<p class="discount arithmetic split">Minus {{$discount}} bulk discount <span>- ${{$subtract=$net*$discount}}</span></p>
					<p class="split">Total Cost <span>${{$final=$net-$subtract}}</span></p>
				</div>
			</div>
			<form class="StripeCheckoutForm" action="{{URL::route('purchase-cards')}}" method="post">
				<button id="StripeCheckout" class="btn btn-info">Buy and Send</button>
				<input id="number" type="hidden" name="number" value="{{$number}}"/>
				<input id="amount" type="hidden" name="amount" value="{{100*$final}}"/>
				<input type="hidden" name="email" value="{{$user->email}}" />
				{{Form::token()}}
			</form>
			
		@endif
	</div><!--end column-->
</div><!--end row-->
<h3>Review your Card</h3>
<div class="quickflip-wrapper">
	<div class="panel1">
		<button class="btn btn-primary quickFlipCta">Flip <icon class="fa fa-refresh"></icon></button>
		<div class="back_text">
			{{$back_text}}
		</div>
		<div class="image-card">
			<img src="{{URL::asset('assets/images/XpressCardsBlank.jpg')}}"></img>
		</div>
	</div>
	<div class="panel2">
		<button class="btn btn-primary quickFlipCta">Flip <icon class="fa fa-refresh"></icon></button>
		<div class="image-card">
			{{$card->renderImage()}}
		</div>
		
	</div>
</div>

@stop
@section('footer')
<script>
	$(function() {
	    $('.quickflip-wrapper').quickFlip({
	    	refresh:true
	    });
	});
	
	
	var submitbutton=document.getElementById('StripeCheckout');
	var amount=$('#amount').val();
	var number=$('#number').val();
	var handler = StripeCheckout.configure({
	    key: '{{Config::get('development/stripe.publishable_key')}}',
	    image: '{{URL::asset('assets/images/XPress_Cards.png')}}',
	    token: function(token, args) {
	       var $input = $('<input type=hidden name=stripe-token />').val(token.id);
	        $('form.StripeCheckoutForm').append($input).submit();
	    } //End Token Function
	  });
	
	  submitbutton.addEventListener('click', function(e) {
	    handler.open({
	      name: 'XPress Cards',
	      description: number+' cards',
	      amount: amount,
	      email: '{{$user->email}}'
	    });
	    e.preventDefault();
	  });
</script>
@stop
