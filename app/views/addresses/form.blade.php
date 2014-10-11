@extends('layout.main')

@section('header')
<script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/2.4/jquery.liveaddress.min.js"></script>
@stop

@section('addresses')
<div>
<h3>{{$user->first}} wants your address</h3>
<form role="form" method="post" action="{{URL::to('address-request-post')}}">
  <div class="form-group">
    <label for="InputName">Your Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
  </div>
  <div class="form-group">
  	<label for="InputEmail">Your Email</label>
  	<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{$email}}">
  </div>
  <div class="form-group">
    <label for="InputAddress">Your Address</label>
    <textarea class="form-control" id="address" name="address" placeholder="Enter your address"></textarea>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
  {{Form::token()}}
  <input type="hidden" name="user" value="{{$user->id}}"/>
</form>
</div>
@stop

@section('footer')
<script>
var LiveAddress= $.LiveAddress({key:"{{Config::get('development/smarty.publishable_key')}}"})
</script>
@stop
