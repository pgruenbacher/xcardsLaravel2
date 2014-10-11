@extends('layout.login')
@section('header')
<style>
		.form-signin,
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
		  margin-bottom: 10px;
		}
		.form-signin .checkbox {
		  font-weight: normal;
		}
		.form-signin .form-control {
		  position: relative;
		  height: auto;
		  -webkit-box-sizing: border-box;
		     -moz-box-sizing: border-box;
		          box-sizing: border-box;
		  padding: 10px;
		  font-size: 16px;
		}
		.form-signin .form-control:focus {
		  z-index: 2;
		}
		.form-signin input[type="email"] {
		  margin-bottom: -1px;
		  border-bottom-right-radius: 0;
		  border-bottom-left-radius: 0;
		}
		.form-signin input[type="password"] {
		  margin-bottom: 10px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}
		.signButton{
			font-size:larger;
		}
		.btn-auth:before {
			    content: "";
			    float: left;
			    width: 22px;
			    height: 22px;
			    background: url({{URL::asset('css/auth-icons.png')}}) no-repeat 99px 99px;
			}
			.auth-button{
				margin: 15px 0px;
			}
			.inline{
				display:inline-block;
			}
			.link{
				color:#2C3E50;
			}	
			.link:hover,.link:focus{
				color:#fff;
			}	
	</style>
	<link rel="stylesheet" href="{{URL::asset('css/auth-buttons.css')}}">
@stop
@section('wrapper')
Login
@stop
@section('content')
	<form class="form-signin" role="form" method="post" action="{{URL::route('account-sign-in-post')}}">
	   
	    <input class="form-control" type="text" name="email" id="email" placeholder="email" {{(Input::old('email')) ? 'value="'.Input::old('email').'"':''}}>
		{{($errors->has('email')) ? $errors->first('email'):''}}
	    <input class="form-control" id="password" type="password" name="password" placeholder="password" required>
	    {{($errors->has('password')) ? $errors->first('password'):''}}
	    <div>
	    	<label>
	    		<input class="pull left"  type="checkbox" name="remember" id="remember" value="remember-me"/> Remember me
		    </label>
		    <a class="pull-right link" href="{{URL::route('account-forgot-password')}}"><b>Forgot password </b><i class="fa fa-question"></i></a>
		 </div>
	    <div class="auth-button">
	    	<a class="btn-auth btn-facebook" href="{{URL::route('facebook-login')}}">Login with <b>Facebook</b></a>
	    </div>
	    <!--
	    <div class="auth-button">
	    	<a class="btn-auth btn-google" href="#button">Login with <b>Google</b></a>
	    </div>
	    -->
	    <button class="signButton btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	    {{Form::token()}}
	</form>
	<a class="btn btn-success btn-block btn-lg" href="{{URL::route('account-create')}}"><i class="fa fa-edit"></i> Create new Account</a>
@stop