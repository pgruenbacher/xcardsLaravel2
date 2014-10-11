<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>X Cards Splash</title>
	<!-- Jquery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/jtable.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/main.min.css')}}">
	
	<!--Font Awesome -->
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	
	@yield('header')
	
</head>
<body>
	@yield('content')
		

	
		
	<footer>
		@yield('footer')
	</footer>
	
	<!--<script src="{{ URL::asset('assets/main.min.js')}}"></script>-->

</body>
</html>