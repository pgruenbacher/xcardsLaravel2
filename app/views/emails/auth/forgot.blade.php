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
	Hello, {{$username}} <br><br>
	
	<p>It looks like you requested a new password, you need to use the following link to activate your new password. If you did not request a new password please ignore this email.</p>
	<br><br>
	
	<p>new password: {{$password}}</p>
	<br><br>
	
	---
	<br>
	<a href="{{$link}}">{{$link}}</a>
	<br>
	---
	</body>
</html>