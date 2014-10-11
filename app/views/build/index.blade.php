@extends('layout.main')

@section('header')
<style>
	.inline{
		display:inline-block;
	}
	.title h1{
		margin-bottom:4px;
		font-family:Times;
		font-size:64px;
		font-weight:700;
		color:#050505;
	}
	.banner{
		background-color:#F39C12;
		border-radius:9px;
		border:2px solid #041b2f;
		margin-bottom:12px;
	}
	ul.features{
		font-size:22px;
		color:#050505;
		margin-top:21px;
	}
	div.choose{
		padding:4px;
	}
	div.choose span{
		color:#050505;
		font-size:24px;
		font-weight:700;
	}
</style>
@stop

@section('addresses')
<div class="row banner">
	<div class="col-md-3">
		<img width="100%" class="img inline" src="{{URL::asset('assets/images/singleImageExample.jpg')}}"/>
	</div>
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-5 text-center title">
				<h1>HIGH RES</h1>
				<p>For high resolution photos taken with a camera</p>
			</div>
			<div class="col-md-7 text-center">
				<ul class="list-unstyled list-inline features">
					<li><i>Premium Quality on glossy stock</i></li>
					<li><i>Personal Image</i></li>
					<li><i>Custom Message</i></li>
					<li><i>First Class</i></li>
					<li><i>Barcode Tracking</i></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 choose">
				<span>Choose how to upload your images <i class="fa fa-arrow-right"></i></span>
			</div>
			<div class="col-md-6">
				<a class="btn btn-lg btn-danger" href="{{URL::route('upload')}}"><i class="fa fa-upload"></i> Upload Image</a>
			</div>	
		</div>
	</div>
</div>
<div class="row banner">
	<div class="col-md-3">
		<img width="100%" class="img inline" src="{{URL::asset('assets/images/instagramExample.jpg')}}"/>
	</div>
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-5 text-center title">
				<h1>COLLAGE</h1>
				<p>For low resolution photos taken by your phone</p>
			</div>
			<div class="col-md-7 text-center">
				<ul class="list-unstyled list-inline features">
					<li><i>Premium Quality on glossy stock</i></li>
					<li><i>Glossy Stock</i></li>
					<li><i>Multiple Images</i></li>
					<li><i>Custom Message</i></li>
					<li><i>First Class</i></li>
					<li><i>Barcode Tracking</i></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 choose">
				<span>Choose how to upload your images <i class="fa fa-arrow-right"></i></span>
			</div>
			<div class="col-md-6">
				<a class="btn btn-lg btn-info" href="{{URL::route('instagram')}}"><i class="fa fa-camera"></i> Instagram</a>
				<a class="btn btn-lg btn-primary" href="{{URL::route('facebook-image')}}"><i class="fa fa-facebook"></i> Facebook</a>
			</div>			
		</div>
	</div>
</div>
@stop


@section('footer')
@stop

