@extends('layout.main')

@section('header')
<script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/2.4/jquery.liveaddress.min.js"></script>
@stop

@section('addresses')

@include('layout.address-nav')

<h1>Edit: {{ $address->addressee }}</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
<div class="col-md-6">
{{ Form::model($address, array('route' => array('address-book.update', $address->id), 'method' => 'PUT')) }}

	<div class="form-group">
		{{ Form::label('addressee', 'Name') }}
		{{ Form::text('addressee', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::email('email', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('address', 'Address') }}
		{{ Form::textarea('address', null, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Edit the Address!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

</div>
@stop

@section('footer')
<script>
var LiveAddress= $.LiveAddress({key:"{{Config::get('development/smarty.publishable_key')}}"},{submitVerify:"false"})
</script>	
@stop
