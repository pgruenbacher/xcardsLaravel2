@extends('layout.frontpage')
@section('header')
<style>
@media (min-width: 979px) {
	#sidebar.affix-top {
	    position: absolute;
	  	margin-top:30px;
	  	width:180px;
	  }
	  
	  #sidebar.affix {
	    position: fixed;
	    top:30px;
	    width:180px;
	  }
		.section{
		padding-left:200px;
		padding-right:200px;
		}
}
	  #sidebar li.active {
		  background:#8AB8E6;
		}
		#sidebar li{
		background:#FFFFFF;
		border-radius:4px;
		}
		#sidebar li a{
		color:#000000;
		font-size:16px;
		}
@media(min-width: 719px){
	.top{
			position:absolute;
			top:60px;
			left:0px;
			right:0px;
		}
	.window{
		padding:100px 200px 100px 200px;
		box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.2) inset, 0px -4px 5px rgba(0, 0, 0, 0.2) inset;
		background-attachment:fixed;
	}
	.secondWindow{
		height:600px;
		background:#ffffff url({{URL::asset('assets/images/exampleCardHeader.jpg')}}) no-repeat center top;
		background-size:contain;
	}
	.thirdWindow{
		height:450px;
		background: url({{URL::asset('assets/images/chloeheader.jpg')}}) no-repeat;
		background-size:cover;
	}
	.fourthWindow{
		height:450px;
		background: url({{URL::asset('assets/images/header4.jpg')}}) no-repeat;
		background-size:cover;
	}
	.fifthWindow{
		height:400px;
		background: url({{URL::asset('assets/images/markheader.jpg')}}) no-repeat;
		background-size:cover;
	}
	.titles{
		display:none;
	}
}
		
		.heading{
			border-radius:4px;
			font-weight:900;
			font-size:84px;
			text-shadow: 2px 2px #000000;
			color:#F0F0F0;
			padding:6px;
			margin-bottom:12px;
		}
		#header{
			background-color:#2C3E50;
			text-align:center;
			box-shadow: 0px -4px 5px rgba(0, 0, 0, 0.2) inset;
			background-size:100%;
			background-position:center center;
		}
		.titles{
			text-align:center;
			border-radius:4px;
			background:white;
			box-shadow:2px 2px 2px rgba(0,0,0,0.4);
		}
		.content{
		padding-top:40px;
		}
		
		.login a.button{
			background:	#333333;
			display: inline-block;
			color: #FFF;
			font-weight:600;
			text-transform:uppercase;
			text-decoration:none;
		}
		.login a.button:hover{
			background:#FF9966;
			transition-delay:all 2s;
			-webkit-transition-delay:all 2s; /* Safari */
		}
		div.gray{
			padding:5.5px 0px 5.5px 0px;
			background:#F0F0F0;
		}
		.content{
		text-align:center;
		}
		.features div div.top{
			min-height:120px;
		}
</style>
@stop

@section('content')
<div class="alert alert-danger" style="margin-bottom: 0px">
	        <a href="#" class="close" data-dismiss="alert">&times;</a>
	        <p><i class="fa fa-warning"></i> Warning, this site is in development mode. We won't process orders</p>
</div>
<div id="header" role="header">
	<img src="{{URL::asset('assets/images/header6.jpg')}}" width="100%"></img>
	<div class="top">
		<div class="row">
	        <!-- tagline -->
	        <div class="animated bounceInUp text-center">
	            <span class="heading">X-Press Cards</span>
	        </div>
	        <div class="login col-md-offset-3 col-md-6 col-xs-12">
	        	<div class="animated fadeInRightBig">
					<a class="btn btn-default btn-lg" href="{{URL::route('account-sign-in')}}"><i class="fa fa-sign-in"></i> Sign In</a>
					<a class="btn btn-default btn-lg" href="{{URL::route('account-create')}}"><i class="fa fa-pencil"></i> Create Account</a>
				</div>
			</div>
	        <!-- /tagline -->
   		</div>
   </div>
</div>
<div class="gray">
	<div class="section">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h1>Send a card to someone today.</h1>
				<h2>We'll deliver it for you!</h2>
			</div>
		</div>
	</div>
</div>
 <!--left-->
  <div class="col-md-2" id="leftCol">
    <ul class="nav nav-stacked" id="sidebar">
      <li><a class="smooth" href="#sec1">How it Works</a></li>
      <li><a class="smooth" href="#sec2">Features</a></li>
      <li><a class="smooth" href="#sec3">Reviews</a></li>
      <li><a class="smooth" href="#sec4">Register</a></li>
    </ul>
  </div>
  <!--/left-->
<div id="sec1" data-stellar-background-ratio="0.5"  class="window secondWindow">
	<div class="row">
		<div class="titles col-md-4 col-md-offset-4">
			<h1>How it Works</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4-offset-4 text-center">
			<a class="btn btn-info btn-lg" href="{{URL::route('build-index')}}">Try it Now!</a>
		</div>
	</div>
</div>	   	
<div class="gray">
	<div class="section">
		<div class="row features">
			<div class="col-sm-4">
				<div>
					 <h1><i class="fa fa-upload"></i> Upload Image</h1>
					  	<ul>
					    	<li>Upload images for the front of the card. Or use photo sharing services like Flickr or Instagram</li>
					    	<li>Crop, Rotate, and Stylize the Photo as necessary</li>
					    </ul>
			    </div>
			</div>
			<div class="col-sm-4 col-sm-6">
				<div>
				 <h1><i class="fa fa-envelope"></i> Build your Card</h1>
				  	<ul>
						<li>Design your card's front and back</li>
				    	<li>Choose from your address book who to send to, we'll handle the rest</li>
				    </ul>
			    </div>
			</div>
			<div class="col-sm-4">
				 <div>
					<h1><i class="fa fa-truck"></i> Direct Delivery</h1>
					<p>Click send and we'll hand the rest. We'll print and postage your cards at the lowest prices available!</p>
  				</div>
	  		</div>
  		</div>
	</div>
</div>
<div id="sec2" data-stellar-background-ratio="0.5" class="window thirdWindow">
	<div class="titles col-md-4 col-md-offset-4">
			<h1>Features</h1>
	</div> 		
</div>
<div class="gray">
	<div class="section">
		<div class="row">
			<div class="col-md-3 col-sm-4">
				<h3><i class="fa fa-barcode"></i> Tracking</h3>
				<p>We use barcodes to track your mail until it is delivered. This also allows for improved address quality and decreased postage costs.</p>
			</div>
			<div class="col-md-3 col-sm-4">
				<h3><i class="fa fa-cog"></i> Strong Foundation</h3>
				<p>Extensive time was spent developing and testing the application. This is our baby.</p>
			</div>
			<div class="col-md-3 col-sm-4">
				<h3><i class="fa fa-users"></i> Large Community</h3>
				<p>You'll be a member of a widespread active community. We developed around social networks to maximize your experience</p>
			</div>
			<div class="clearfix visible-sm"></div>
			<div class="col-md-3 col-sm-4">
				<h3><i class="fa fa-road"></i>Address Verification</h3>
				<p>We use smarty street address verification to make sure your card gets where it's meant to</p>
			</div>
			<div class="clearfix visible-md visible-lg"></div>
			<div class="col-md-3 col-sm-4">
				<h3><i class="fa fa-print"></i> Quality Printing</h3>
				<p>We only print from the best services available. You'll love our gloss stock</p>
			</div>
			<div class="col-md-3 col-sm-4">
				<h3><i class="fa fa-plane"></i> International</h3>
				<p>Overseas? That's the perfect time to use our app to send a postcard back to the United States!</p>
			</div>
			<div class="clearfix visible-sm"></div>
			<div class="col-md-3 col-sm-4">
				<h3><i class="fa fa-qrcode"></i> Cards that Share</h3>
				<p>Our cards have the ability to use QR codes to share any link you want!</p>
			</div>
			<div class="col-md-3 col-sm-4">
				<h3><i class="fa fa-credit-card"></i> Pre-paid Credits</h3>
				<p>Buy and share credits to share with your children. Finally a way to have them send out thank you card!</p>
			</div>
		</div>
	</div>
</div>
<div id="sec3" data-stellar-background-ratio="0.5" class="window fourthWindow">
	<div class="titles col-md-4 col-md-offset-4">
			<h1>Reviews</h1>
	</div> 	
</div>
<div class="gray">
	<div class="section">
		<div class="row">
			<div class="col-lg-4 col-sm-6">
				<blockquote>
			 		<p><i class="fa fa-quote-left pull-left"></i>I sent a postcard to my grandma and it was so easy to use she was able to send one back. Thanks! <i class="fa fa-quote-right pull-right"></i></p>
				  	<footer>Chloe Aparcedo</footer>
				</blockquote>
			</div>
			<div class="col-lg-4 col-sm-6">
				<blockquote>
			 		<p><i class="fa fa-quote-left pull-left"></i>A very crafty, affordable and thoughtful way to send photos to someone! Thanks guys!<i class="fa fa-quote-right pull-right"></i></p>
				  	<footer>Craig Hunker</footer>
				</blockquote>
			</div>
			<!-- Add the extra clearfix for only the required viewport -->
  			<div class="clearfix visible-sm"></div>
			<div class="col-lg-4 col-sm-6">
				<blockquote>
			 		<p><i class="fa fa-quote-left pull-left"></i>X-Press Card's has a very easy to use interface! Makes it easy to send postcards to friends and family!<i class="fa fa-quote-right pull-right"></i></p>
				  	<footer>Peter Reese</footer>
				</blockquote>
			</div>
			<div class="col-lg-4 col-sm-6">
				<blockquote>
			 		<p><i class="fa fa-quote-left pull-left"></i>I travel a lot and sent a few postcards home. My family absolutely loved it!<i class="fa fa-quote-right pull-right"></i></p>
				  	<footer>Ann Ricter</footer>
				</blockquote>
			</div>
			<!-- Add the extra clearfix for only the required viewport -->
  			<div class="clearfix visible-sm"></div>
			<div class="col-lg-4 col-sm-6">
				<blockquote>
			 		<p><i class="fa fa-quote-left pull-left"></i>You guys are cheap and have a very fast, affordable service! Thanks a lot!<i class="fa fa-quote-right pull-right"></i></p>
				  	<footer>Megan Reese</footer>
				</blockquote>
			</div>
			<div class="col-lg-4 col-sm-6">
				<blockquote>
			 		<p><i class="fa fa-quote-left pull-left"></i>A gift that's both tangible and heartfelt. An effective way to show you care to those you love<i class="fa fa-quote-right pull-right"></i></p>
				  	<footer>Eric Gruenbacher</footer>
				</blockquote>
			</div>
		</div>
	</div>
	
</div>
<div id="sec4" data-stellar-background-ratio="0.5" class="window fifthWindow">
	<div class="titles col-md-4 col-md-offset-4">
			<h1>Interested?</h1>
	</div> 	
</div>  
<div class="gray">
	<div class="section">
		<div class="row">
			<div class="col-md-4">
				<h3>Our mobile app is still in development <small>But we can let you know when it's released!</small></h3>
			</div>
			<div class="col-md-4">
				<h3>Sign up for newsletter</h3>
				<form>
					<div class="list-inline form-inline">
						<input class="form-control" id="email" tpe="email" name="email"/>
						<a id="submit" class="btn btn-info">Submit</a>
					</div>
				</form>
			</div>
			<div class="col-md-4">
				<h3>Want to learn more? Visit our <a href="{{URL::route('contact')}}">Contact Page</a></h3>
			</div>
		</div>
		
	</div>
</div>	   	
@stop

@section('footer')
<script>
		$(document).ready(function(){
			/* Alert Button */
			$(".alert button.close").click(function (e) {
	    		$(this).parent().fadeOut('slow');
			});
		    /* Enable Smooth Scroll for non-Firefox Users */
		    $.srSmoothscroll();    
		    
			//Stellar, keep in body.
			$(function(){
				$.stellar({
					horizontalScrolling: false,
					verticalOffset: 0
				});
			});
		    
			/**Bootply affix sidebar or navigation */
			$('#sidebar').affix({
			      offset: {
			         top: $('#sidebar').offset().top,
			         bottom: function () {
			        	return (this.bottom = $('.footer').outerHeight(true));
			     	 }
			 	  }
			});
			
			/* Bootpy http://www.bootply.com/100983 */
			var $body   = $(document.body);
			var Height = $(window).height();
			
			$body.scrollspy({
				target: '#leftCol',
				offset: Height
			});
			
			$body.on('activate.bs.scrollspy', function() {
			   var id =$(this).find('#sidebar li.active a').attr("href");
			   console.log(id);
			   $(id).find('div.titles').addClass('animated fadeInRightBig').show();
			});
			
			/* smooth scrolling sections */
			$('.smooth').click(function() {
			    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			      var target = $(this.hash);
			      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			      if (target.length) {
			        $('html,body').animate({
			          scrollTop: target.offset().top 
			        }, 500);
			        return false;
			      }
			    }
			});
		});
</script>
@stop
