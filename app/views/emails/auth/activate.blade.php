<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>X-Cards 4 Account</title>
    <style type="text/css">

      body {
        padding     : 25px 0;
        font-family : Helvetica;
      }
    </style>
  </head>
  <body>
  	<div id="logo">
    	<a href="{{URL::route('home')}}"><img src="{{URL::asset('assets/images/mrbunny-white.gif')}}"></a>
 	</div><!--end logo-->
  	<p>Hello {{$name}}, </p>
  	<br><br>
	<p>Please activate your account using the following link.</p>
	<br><br>
	
	--<br>
	<a href="{{$link}}">{{$link}}</a><br>
	--
  </body>
</html>


