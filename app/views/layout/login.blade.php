<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="@yield('meta_description')"/>
    <meta name="keywords" content="@yield('meta_keywords')"/>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="{{URL::asset('assets/images/browser-icon.gif')}}"/>
	<link rel="shortcut icon" href="{{URL::asset('assets/images/browser-favicon.gif')}}" />

    <title>Signin</title>
    <!-- Jquery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

    <!--Bootstrap-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<!-- Optional theme -->
	<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">-->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap/flatly.bootstrap.min.css')}}">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<!--Font Awesome -->
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<style>
	@media (min-width: 927px){
		body{
			  padding-top: 40px;
			  padding-bottom: 40px;
			  background:url({{URL::asset('assets/images/mrbunny.gif')}}) no-repeat left top;
			}
		}
		body{
			background-color:#D9D6CF;
		}
		.signin {
		  max-width: 330px;
		  padding: 15px;
		  margin: 0 auto;
		  background-color:#AEAEAE;
		  border:#2C3E50 4px solid;
		}
		#wrapper{
			background-color:#2F4D6B;
			position:relative;
			padding:2px 30px;
			margin:10px -30px 20px -30px;
		}
		#wrapper:before,
		#wrapper:after {
			content:" ";
			border-top:10px solid #2C3E50;
			position:absolute;
			bottom:-10px;
		} 
		#wrapper:before {
			border-left:10px solid transparent;
			left:0;
			}
		#wrapper:after {
			border-right:10px solid transparent;
			right:0;
		}
		div.title{
			text-align:center;
		}
		div.title h2{
			color:#ffffff;
			font-weight:600;
		}
		div.header h1{
			font-weight:800;
			text-align:center;
		}
		a.homeLink{
			text-decoration:none;
			color:#2C3E50;
		}
	</style>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-52002611-1', 'x-presscards.com');
	  ga('send', 'pageview');
	</script>
	@yield('header')
	
  </head>

  <body>
  	<div class="container">
		@if(Session::has('global'))
		<div class="alert alert-success">
	        <a href="#" class="close" data-dismiss="alert">&times;</a>
			<p>{{Session::get('global')}}</p>
		</div>
		@endif
		@if(Session::has('flash_message'))
		<div class="alert alert-danger">
	        <a href="#" class="close" data-dismiss="alert">&times;</a>
	        <p>{{Session::get('flash_message')}}</p>
	    </div>
	    @endif
	    
	    <div class="signin">
			<div class="header">
				<h1><a class="homeLink" href="{{URL::route('splash')}}">X-Press Cards</a></h1>
			</div>
			<div id="wrapper" class="ribbon title">
				<h2>@yield('wrapper')</h2>
			</div>
			@yield('content')				
		</div>
 	</div> <!-- /container -->


  </body>
  <footer>
  	<script>
  		$(".alert button.close").click(function (e) {
    		$(this).parent().fadeOut('slow');
		});
  	</script>
  	@yield('footer')
  </footer>
</html>
