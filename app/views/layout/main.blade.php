<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Xpress Cards</title>
	<link rel="icon" href="{{URL::asset('assets/images/browser-icon.gif')}}"/>
	<link rel="shortcut icon" href="{{URL::asset('assets/images/browser-favicon.gif')}}" />
	<meta name="description" content="@yield('meta_description')"/>
    <meta name="keywords" content="@yield('meta_keywords')"/>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<script>
	if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
	    var msViewportStyle = document.createElement("style");
	    msViewportStyle.appendChild(
	        document.createTextNode(
	            "@-ms-viewport{width:auto!important}"
	        )
	    );
	    document.getElementsByTagName("head")[0].
	        appendChild(msViewportStyle);
	}
	</script>
	<!-- Jquery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="{{URL::asset('js/jQuery/jquery-ui-git.js')}}"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">-->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap/flatly.bootstrap.min.css')}}">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/jtable.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/main.min.css')}}">
	
	<!--Font Awesome -->
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	
	<style>
		html,body{
			height:100%;
		}
		#wrap {
			min-height: 100%;
			height: auto;
			/* Negative indent footer by its height */
			margin: 0 auto -200px;
			/* Pad bottom by footer height */
			padding: 0 0 200px;
		}
		div.footer-bottom{
			min-height:200px;
			margin-top:15px;
			background:	#2C3E50;
			box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.2) inset, 0px -4px 5px rgba(0, 0, 0, 0.2) inset;
			padding:17px;
			color:#FFF
		}
		div.footer h1{
			font-family:"Verdana", Geneva, sans-serif;
			font-weight:bolder;
		}
		.inline-list li{
			display:inline-block;
			margin-right:40px;
		}
		.footer-list ul{
			list-style:none
		}
		.list-item{
			text-transform:uppercase;
			font-size:18px;
			text-decoration:none;
			color:inherit;
		}
		.list-item-header{
			text-transform:uppercase;
		}
		.navigator{
			margin-top:-21px;
			margin-bottom: 21px;
			background-color: #2C3E50;
		}
		.navigator>div>*{
			display:inline-block;
		}
		.inline-divs>*{
			display:inline-block;
		}
		.breadcrumbs{
			padding: 10px 15px;
			list-style: none outside none;
		}
		.breadcrumbs li{
			display:inline-block;
		}
		.breadcrumbs ul{
			margin-bottom:0px;
		}
		.breadcrumbs .active{
			color:#95A5A6;
		}
		.breadcrumbs ul  li + li:before {
		    content: "> ";
		    padding: 0px 5px;
		    color: #CCC;
		}
		.previewBanner{
			margin-top:-21px;
			color:white;
			padding:10px; 40px;
		}
		.previewBanner h1{
			margin-top:4px;
		}
		.yellowBanner{
			background-color:#F39C12;
			border-radius:9px;
		}
		.yellowBanner .previewContainer{
			box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
			overflow:hidden;
			height:70px;
			width:105px;
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
	<div id="wrap">
		<div class="header">
			<div class="navigation">
				@include('layout.navigation')
			</div><!--end navigation-->
			@yield('slider')
			@if(Breadcrumbs::exists())
			<div class="navigator">
				<div class="container">
					{{Breadcrumbs::render()}}
					<a id="backwardButton" class="pull-left btn btn-primary"><i class="fa fa-chevron-left"></i> Previous</a>
					<a id="forwardButton" class="pull-right btn btn-primary">Next <i class="fa fa-chevron-right"></i></a>
				</div>
			</div>
				@if(Cards::find(Session::get('card'))->hasType())
					{{Cards::renderPreviewBanner()}}
				@endif
			@endif
		</div><!-- end header-->
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
			@yield('addresses')	
			@yield('billing')
			@yield('account')
		</div><!--End Container-->
	</div><!--End Wrap-->
	<div class="footer-bottom">
		@include('layout.footer-nav')
	</div>
	<footer>
		@yield('footer')
	</footer>
	<!--<script src="{{ URL::asset('assets/main.min.js')}}"></script>-->
	</div><!-- Wrapper-->
</body>
</html>