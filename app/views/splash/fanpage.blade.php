@extends('layout.frontpage')
@section('header')
<style>
	.divider{
		margin-top:80px;
	}
</style>
@stop
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-7 text-center">
			<h2>Brutus Coniculus</h2>
			<form method="POST" action="{{URL::route('fanpage')}}">
				<input type="hidden" name="pet" value="Brutus">
				<button class="btn btn-lg btn-success">Send Brutus a card</button>
			</form>
			<p class="text-muted">And we'll send one back!</p>
		</div>
		<div class="col-md-5">
				<img class="img-circle" src="{{URL::asset('assets/images/rabbit-profile.jpg')}}"/>
		</div>
	</div>
	<hr class="divider"></hr>
	<div class="row">
		<div class="col-md-5">
			<img class="img-circle" src="{{URL::asset('assets/images/Bentley-profile.jpg')}}"/>
		</div>
		<div class="col-md-7 text-center">
			<h2>Bentley Burberry</h2>
			<form method="POST" action="{{URL::route('fanpage')}}">
				<input type="hidden" name="pet" value="Bentley">
				<button class="btn btn-lg btn-success">Send Bentley a card</button>
			</form>
			<p class="text-muted">And we'll send one back!</p>
		</div>
	</div>
</div>
@stop
@section('footer')

@stop
