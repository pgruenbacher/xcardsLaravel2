@extends('layout.frontpage')
@section('header')

@stop
@section('content')
<h1>We offer multiple printing services</h1>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Postcards
			</div>
			<div class="panel-body">
				<div class="postcard">
					<img width="100%" src="{{URL::asset('assets/images/postcard-printing.png')}}"/>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Sealed Letters
			</div>
			<div class="panel-body">
				coming soon...
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Folding Cards
			</div>
			<div class="panel-body">
				Coming soon...
			</div>
		</div>
	</div>
</div>
@stop
@section('footer')


@stop
