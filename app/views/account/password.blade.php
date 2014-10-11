@extends('layout.main')

@section('account')
	<form role="form" action="{{URL::Route('account-change-password-post')}}" method="post">
		<div class="form-group">
			<label for="old_password">Old Password:</label>
			<input class="form-control" id="password" type="old_password" name="old_password"/>
			@if ($errors->has('old_password'))
				{{$errors->first('old_password')}}
			@endif
		</div>
		<div class="form-group">
			<label for="password">New Password: </label>
			<input class="form-control" type="password" id="password" name="password"/>
			@if ($errors->has('password'))
				{{$errors->first('password')}}
			@endif
		</div>
		<div class="form-group">
			<label for="password_again">Confirm Password: </label>
			<input class="form-control" type="password" id="password_again" name="password_again"/>
			@if ($errors->has('password_again'))
				{{$errors->first('password_again')}}
			@endif
		</div>
		<input type="submit" value="Change Password" />
		{{Form::token()}}
	</form>
@stop
