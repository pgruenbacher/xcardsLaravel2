@extends('layout.main')

@section('header')
<style>
	div.thumbnail{
		width:136px;
		height:100px;
		overflow:hidden;
	}
</style>

@stop
@section('addresses')
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th></th>
			<th>Image</th>
			<th>Message</th>
			<th>Recipients</th>
			<th>Sent</th>
			<th>Order #</th>
		</tr>
	</thead>
	<tbody>
		@foreach($cards as $card)
			<tr>
				<td><a class="btn" href="{{URL::to('redirect').'?id='.$card->id.'&url='.$card->nextRoute()}}">{{$card->finished_at > 0 ? 'Use this card again':'Finish this card'}}</a></td>
				<td>
					<div class="thumbnail">
						{{$card->renderThumbnail()}}
					</div>
				</td>
				<td>{{$card->back_text}}</td>
				<td>
					@foreach($card->addresses()->get() as $address)
						<li>{{$address['addressee']}}</li>
					@endforeach
				</td>
				<td>{{$card->finished_at > 0 ? date('M d Y',$card->finished_at) : 'incomplete'}}</td>
				@if(! is_null($card->orders()->first()))
				<td>{{$card->orders()->first()->reference_number}}</td>
				@else
				<td></td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>
	


@stop
@section('footer')


@stop
