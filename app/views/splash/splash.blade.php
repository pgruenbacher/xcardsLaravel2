@extends('layout.frontpage')
@section('header')
<style>
@media (min-width: 979px) {
	.row-md-height{
		margin-left:0px;
		margin-right:0px;
	}
	.row-md-height>div{
		min-height:340px;
	}
	.background-container{
		height:inherit;
	}
}
	.dark-blue{
		background-color:#2C3E50;
		color:#fff;
	}
	.splash-banner{
		margin-top:-21px;
		background:url({{URL::asset('assets/images/splash-banner.gif')}});
		background-size:cover;
		background-position:bottom center;
		min-height:500px;
	}
	.lighter-blue{
		background-color:#D8E2F0;
	}
	.light-blue{
		background-color:#fffaed;
	}
	.light-grey{
		background-color:#DACDD6;
	}
	.pale-blue{
		background-color:#c9cae3;
		
	}
	.light-yellow{
		background-color:#EBFF8C;
	}
	.white{
		background-color:#ffffff;
	}
	.center{
	text-align:center;	
	}
	.center-img{
		display: block;
	    margin-left: auto;
	    margin-right: auto;
	}
	.app-store>img{
		margin-bottom:10px;
	}
	.mailman{
		display:table-cell;
		vertical-align:bottom;
	}
	.background-image{
		position:absolute;
		top:0px;
		left:0px;
		width:100%;
	}
	.background-sharing-container{
		background: #dce1e0 url({{URL::asset('assets/images/credit-sharing.gif')}}) no-repeat;
		background-position:right bottom;
		background-size:auto 100%;
	}
	.foreground-container{
		height:300px;
	}
	.instructions{
		font-size:18px;
	}
	
	
</style>
@stop

@section('content')
<div class="row splash-banner light-grey">
	<div class="container">
		<h1>Fast, Simple Printing with Direct Delivery</h1>
		<a class="btn btn-info btn-lg" href="{{URL::route('account-sign-in')}}">Login</a>
		<a class="btn btn-warning btn-lg" href="{{URL::route('account-create')}}">Create Account</a>
	</div>
</div>
<div class="row white">
	<div class="container">
		<div class="row row-md-height">
			<div class="col-md-4 background-sharing-container">
				<div class="foreground-container">
					<h2>Kids away from home?</h2>
					<table width="100%;">
						<tbody>
							<tr>
								<td class="instructions">Send them credits</td>
								<td class="instructions pull-right">They'll send back cards</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-4 lighter-blue">
				<table>
					<tbody>
						<tr>
							<td style="width:60%">
								<h2>Address verification and Tracking</h2>
								<p class="lead">Delivery assured</p>
								<p>We don't just handle postage, we also validate addresses and perform intelligent tracking</p>
							</td>
							<td style="width:40%; vertical-align:bottom;">
								<img class="img-responsive" src="{{URL::asset('assets/images/mailman.gif')}}"/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-4 pale-blue">
				<h2 class="center">Device Apps</h2>
				<img class="img-responsive" src="{{URL::asset('assets/images/EveryDevice.gif')}}"/>
				<div class="row">
					<div class="col-md-4">
						<a class="app-store"><img width="100%" src="http://www.scaladays.org/assets/images/android-app-on-google-play-EN.png"></a>
					</div>
					<div class="col-md-4">
						<a class="app-store"><img width="100%" src="http://www.gtdagenda.com/images/appstore.png"></a>
					</div>
					<div class="col-md-4">
						<a class="app-store" href="#"><img width="100%" src="{{URL::asset('assets/images/462x120_WP_Store_blk.png')}}"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row white">
	<div class="container">
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
<div class="row">
	<div class="container">
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
@stop

@section('footer')
<script>
		$(document).ready(function(){
			/* Alert Button */
			$(".alert button.close").click(function (e) {
	    		$(this).parent().fadeOut('slow');
			});
		    /* Enable Smooth Scroll for non-Firefox Users */
		     
		    
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
