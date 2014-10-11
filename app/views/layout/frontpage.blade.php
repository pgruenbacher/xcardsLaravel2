<!doctype html>
<html lang="en">
<head>
	<meta property="og:title" content="X-Press Cards"/>
	<meta property="og:image" content="{{URL::asset('assets/images/instagramExample.jpg')}}"/>
	<meta property="og:description" content="Online printing cards with direct delivery to recipients"/>
	<meta property="og:url" content="http://www.paulgruenbacher.com/xcards" />
	<meta charset="UTF-8">
	<title>Xpress Cards</title>
	<link rel="icon" href="{{URL::asset('assets/images/browser-icon.gif')}}"/>
	<link rel="shortcut icon" href="{{URL::asset('assets/images/browser-favicon.gif')}}" />
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	
	<!--Stellar-->
	<script type="text/javascript" src="{{URL::asset('js/stellar/jquery.stellar.min.js')}}"></script>
	
	<!--Smooth Scroll-->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.0.6/jquery.mousewheel.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{URL::asset('js/simplr.smoothscroll.min.js')}}" type="text/javascript" charset="utf-8"></script>
	
	<!--Bootstrap-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<!-- Optional theme -->
	<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">-->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap/flatly.bootstrap.min.css')}}">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	
	<!--Font Awesome -->
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">	
	<!--Image Holder-->
	<script src="{{URL::asset('js/imsky/holder.js')}}"></script>
	<!--Animate.css-->
	<link href="{{URL::asset('css/animate/animate.min.css')}}" rel="stylesheet">
	<style>
	`	html,body{
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
		/*
		 * Footer Section
		 * 
		 */
		div.footer-bottom{
			min-height:200px;
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
		/*End Footer */
	</style>
	
	@yield('header')
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-52002611-1', 'x-presscards.com');
	  ga('send', 'pageview');
	</script>
</head>
<body>
	<div id="wrap">
		@include('layout.navigation')
		@yield('content')
	</div>
	<div class="footer-bottom">
		@include('layout.footer-nav')
	</div>
	<footer >
		@yield('footer')
		<script type="text/javascript"> 
		var $buoop = {}; 
		$buoop.ol = window.onload; 
		window.onload=function(){ 
			 try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
			 var e = document.createElement("script"); 
			 e.setAttribute("type", "text/javascript"); 
			 e.setAttribute("src", "//browser-update.org/update.js"); 
			 document.body.appendChild(e); 
		} 
		</script> 
	</footer>
	<!--<script src="{{ URL::asset('assets/main.min.js')}}"></script>-->
	<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('1810-408-10-9901');/*]]>*/</script><noscript><a href="https://www.olark.com/site/1810-408-10-9901/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->
</body>
</html>