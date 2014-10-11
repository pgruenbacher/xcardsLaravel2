@extends('layout.address-book')

@section('addresses')

@include('layout.address-nav')

<h1>{{$address->addressee}}</h1><a class="btn btn-small btn-info" href="{{URL::to('address-book/'.$address->id.'/edit')}}">Edit</a>

	<div class="jumbotron text-center">
		<h2>{{$address->addressee}}</h2>
		<p>
			<strong>Email:</strong>{{$address->email}} <br>
			<strong>Address Line 1:</strong>{{$address->address}} 
		</p>
	</div>

</div>
@stop
