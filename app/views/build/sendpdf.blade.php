@extends('layout.card')
@section('header')
<style>
div.edited{
		top:30px;
		left:25px;
		width:410;
		position:absolute;
		z-index: 10;
	}
img.standard{
	position:relative;
	width:900px;
	border:solid 1px;
}
p,span{
	font-size:7pt !important
}
</style>
@stop
@section('card')
<div class="edited">
	{{$raw}}
</div>
<img class="standard" src="{{URL::asset('assets/images/XpressCardsBlank.jpg')}}"></img>
@stop
@section('footer')
<script>
	
</script>
@stop
