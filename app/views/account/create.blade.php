@extends('layout.login')
@section('header')
<script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/2.4/jquery.liveaddress.min.js"></script>
<style>
		
		.form-create .form-create-heading,
		.form-create .form-control {
		  position: relative;
		  height: auto;
		  -webkit-box-sizing: border-box;
		     -moz-box-sizing: border-box;
		          box-sizing: border-box;
		  padding: 10px;
		  font-size: 16px;
		}
		.content-area {
		    display:none;
		    height:200px;
		    overflow:auto;
		    margin-bottom:1.5em;
		    padding:10px;
		    border:solid 1px #d7d7d7;
		    color:#505050;
		    background-color:#ffffff;
		    font-size:90%;
		}
		.link{
			color:#8D2ED1;
		}	
		.link:hover,.link:focus{
			color:#fff;
		}	
</style>
@stop
@section('wrapper')
Create Account
@stop
@section('content')
	<form class="form-create" action="{{URL::route('account-create-post')}}" method="post" role="form">
			<h2 class="form-create-heading">Create your Account</h2>
			<div class="form-group">
			<label for="first">First name: </label>
			<input class="form-control" type="text" name="first" id="first"{{(Input::old('first'))?' value="'.Input::old('first').'"' : ''}}/> 
			@if($errors->has('email')){
				{{$errors->first('first')}}
			}
			@endif
			</div>
			<div class="form-group">
			<label for="last">Last name: </label>
			<input class="form-control" type="text" name="last" id="last"{{(Input::old('last'))?' value="'.Input::old('last').'"' : ''}}/> 
			@if($errors->has('last')){
				{{$errors->first('last')}}
			}
			@endif
			</div>
			<div class="form-group">
			<label for="inputemail">Email: </label>
			<input class="form-control" type="text" name="email" id="inputemail"{{(Input::old('email'))?' value="'.Input::old('email').'"' : ''}}/> 
			@if($errors->has('email')){
				{{$errors->first('email')}}
			}
			@endif
			</div>
			<div class="form-group">
			<label for="inputAddress">Address: </label>
			<textarea class="form-control" type="text" name="address" id="inputAddress"{{(Input::old('address'))?' value="'.Input::old('address').'"' : ''}}></textarea> 
			@if($errors->has('address')){
				{{$errors->first('address')}}
			}
			@endif
			</div>
			<div>
				We take your <a class="link" href="{{URL::route('privacy')}}" id="privacy">terms &amp; privacy</a> seriously.
			</div>
			<div class="content-area" id="privacy-area"></div>
			<div class="form-group">
			<label for="password">password: </label>
			<input class="form-control" type="password" id="password" name="password"/>
			@if($errors->has('password')){
				{{$errors->first('password')}}
			}
			@endif
			</div>
			<div class="form-group">
			<label for="password2">confirm password:</label>
			<input class="form-control" type="password" id="password2" name="password_again"/>
			@if($errors->has('password_again')){
				{{$errors->first('password_again')}}
			}
			@endif
			</div>
			<div>
				<input type="checkbox" required/> I agree to the <a class="link" href="{{URL::route('website-terms')}}" id="terms">terms &amp; conditions</a>
			</div>
  			<div class="content-area" id="terms-area"></div>
		<input type="submit" class="btn btn-success" value="create account"/>	
		{{Form::token()}}	
	</form>
@stop
@section('footer')
<script>
	jQuery.LiveAddress("{{Config::get('development/smarty.publishable_key')}}");
	
	$(function() {
    	$("#terms").terms_agree("#terms-area", "#small-print");
    	$("#privacy").terms_agree("#privacy-area", "#small-print");
	});
	jQuery.fn.terms_agree = function(content_area, selector) {
    var body = $(body);
    $(this).click(function() {
        body.css("height", "auto").css("height", body.height()); // Prevent page flicker on slideup
        if ($(content_area).html() == "") {
        	console.log('yes');
            $(content_area).load( $(this).attr("href") + (selector ? " " + selector : "") );
        }
        $(content_area).slideToggle();
        return false;
    });
}
</script>
@stop
