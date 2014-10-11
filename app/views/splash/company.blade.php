@extends('layout.frontpage')
@section('header')
<style>
	.title{
		text-decoration:underline;
	}
</style>
@stop
@section('content')
<div class="container">
<div class="row">
	<div class="col-lg-10 col-lg-offset-1 text-center">
		<img class="img-responsive center-block" src="{{URL::asset('assets/images/mrbunny2-white.gif')}}">
		<h1 class="title">X-Press Cards LLC</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<h2 class="text-center">Our Mission</h2>
		<p>We're striving to make the world more friendly and personal. The social world is increasingly sharing its memories digitally. We want to help you share them with cards you can hold in your hand.
		By offering the highest quality in printing and online services, we're bringing the world closer together.</p>
	</div>
</div>
<hr class="divider"></hr>
<div class="row">
	        <div class="col-md-4">
	          <img class="img-circle" src="{{URL::asset('assets/images/paul.jpg')}}">
	          <h2>Paul Gruenbacher</h2>
	          <h3>Lead Developer</h3>
	          <p>Paul is a chemical engineer at the Ohio State University. He built the company's website and app. His areas expertise includes Php, jQuery, Laravel Framework, and PhoneGap Implementation. Paul is focused on all technical sides of the company.</p>
	          <p><a class="btn btn-default" href="{{URL::route('contact')}}#paul" role="button">View details &raquo;</a></p>
	        </div><!-- /.col-lg-4 -->
	        <div class="col-md-4">
	          <img class="img-circle" src="{{URL::asset('assets/images/john.jpg')}}">
	          <h2>John Gruenbacher</h2>
	          <h3>Business Manager</h3>
	          <p>If you would like to discuss any business opportunities, please contact John, our manager! He is an Engineering student at The Ohio State University. His interests include frisbee and sand volleyball. He looks up to his older brother Paul as his hero.</p>
	          <p><a class="btn btn-default" href="{{URL::route('contact')}}#john" role="button">View details &raquo;</a></p>
	        </div><!-- /.col-lg-4 -->
	        <div class="col-md-4">
	          <img class="img-circle" src="{{URL::asset('assets/images/rabbit-profile.jpg')}}">
	          <h2>Brutus Coniculus</h2>
	          <h3>Hare Honcho</h3>
	          <p>Not a day goes by where Brutus does not lend sage advice to the tasks at hand. His interests include sleeping, relaxing, and chewing. Truly a lifestyle fo follow.</p>
	          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
	        </div><!-- /.col-lg-4 -->
       </div><!-- /.row -->
</div>
@stop
@section('footer')

@stop

