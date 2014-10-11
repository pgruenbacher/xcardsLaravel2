@extends('layout.main')
@section('header')
<style>
	.slider {
	    background: url('{{URL::asset('assets/images/Slider.png')}}') repeat-x;
	    width: 100%;
	    height: 131px;
		}
	.navbar{
		margin-bottom: -20px;
	}
	div.thumbnail{
		width:136px;
		height:90.67px;
		overflow:hidden;
	}
		
</style>
@stop
@section('slider')
<div class="slider">
	</div>
@stop
@section('addresses')
<h1>Home</h1>
<div class="row">
	<div class="col-md-4">
		<p>My credits: <span class="credits" style="color:red;">{{Auth::user()->credits}}</span></p>
		<p>Share my credits to another user, or send email enabling them to use one</p><a class="btn btn-warning" href="{{URL::route('exchange')}}"><i class="fa fa-share"></i>Share</a>
	</div>
	<div class="col-md-4">
		<h3>Notifications</h3>
	</div>
	<div class="col-md-4">
		<table class="table table-condensed table-striped">
			<thead>
				<tr>
					<th>Friend</th>
					<th># Credits</th>
					<th>Date</th>
					<th>Complete?</th>
				</tr>
			</thead>
			<tbody>
				@foreach($outgoingTransfers as $outgoing)
					<tr>
						<td>{{$outgoing->recipient()? $outgoing->recipient()->first()->fullName():'account deleted'}}</td>
						<td>{{$outgoing->credits}}</td>
						<td>{{date('M d Y', strtotime($outgoing->created_at))}}</td>
						<td>{{$outgoing->confirmed?'yes':'no'}}</td>
					</tr>
				@endforeach
			</tbody>			
		</table>
	</div>
</div><!--end first row-->
@if(!($incomingTransfers->isEmpty()))
	{{Transfers::printModal($incomingTransfers)}}
@endif
<div class="row">
	<div class="col-md-5">
		<div class="addresses">
			<h3>Recently Added Addresses</h3>
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Address</th>
						<th>Added</th>
					</tr>
				</thead>
				<tbody>
					@if(isset($addresses))
						@foreach($addresses as $address)
							<tr>
								<td>{{$address['addressee']}}</td>
								<td>{{$address['address']}}</td>
								<td>{{date('M d Y', strtotime($address['created_at']))}}</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-7">
		<div class="cards">
			<h3>Recent Cards</h3>
			<a href="{{URL::route('build-previous')}}">Review all Cards</a>
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th></th>
						<th>Image</th>
						<th>Recipients</th>
						<th>Created</th>
						<th>Charge</th>
						<th>Ref #</th>
					</tr>
				</thead>
				<tbody>
					@if(isset($cards))
						@foreach($cards as $card)
							<tr>
								<td><a class="btn" href="{{URL::to('redirect').'?id='.$card->id.'&url='.$card->nextRoute()}}">{{$card->finished_at > 0 ? 'Use this card again':'Finish this card'}}</a></td>
								<td><div class="thumbnail">{{$card->renderThumbnail()}}</div></td>
								<td>
									<ul>
									@foreach($card->addresses()->get() as $address)
										<li>{{$address['addressee']}}</li>
									@endforeach
									</ul>
								</td>
								<td>{{date('M d Y', strtotime($card['created_at']))}}</td>
								@if(! is_null($card->orders()->first()))
								<td>{{empty($card->orders()->first()->charge) ? $card->orders()->first()->credits : '$'.$card->orders()->first()->charge/100 }}</td>
								<td>{{$card->orders()->first()->reference_number}}</td>
								@else
								<td></td>
								<td></td>
								@endif
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('footer')
<script>
	$(document).ready(function(){
		console.log('start');
		/* Laravel Scrolling Pictures */
		    var speed = 80;
		    var pos = 0;
		    var horizontal = true;
		    
		    function bgScroll(){
		    	console.log('scroll');
		        pos -= 1;
		        $('.slider').css(
		            'backgroundPosition',
		            (horizontal) ? pos + 'px 0' : '0 ' + pos + 'px'
		        );
			}
			setInterval(bgScroll, speed);
	});
</script>
@stop
