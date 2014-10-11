@extends('layout.login')
@section('header')
<style>
	.form-forgot .form-forgot-heading,
	.form-forgot .form-control {
	  position: relative;
	  height: auto;
	  -webkit-box-sizing: border-box;
	     -moz-box-sizing: border-box;
	          box-sizing: border-box;
	  padding: 10px;
	  font-size: 16px;
	}
		
</style>
@stop
@section('wrapper')
	Recover Account
@stop
@section('content')
<form class="form-forgot" role="form" action="{{URL::route('account-forgot-password-post')}}" method="post" {{(Input::old('email'))?'value="'.Input::old('email').'"':''}}>
	<h2 class="form-forgot-heading">Send reset password to your email</h2>
	<div class="form-group">
		<label>Email: </label>
		<input class="form-control" type="email" name="email" />
		@if($errors->has('email'))
		{{$errors->first('email')}}
		@endif
	</div>
	<input class="btn btn-block btn-primary" type="submit" value="recover" />
	{{Form::token()}}
</form>
@stop
