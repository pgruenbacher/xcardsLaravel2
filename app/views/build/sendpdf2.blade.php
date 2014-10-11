@extends('layout.card')
@section('header')
<style>
@page { margin: 0px; }
body { margin: 0px; }
html{margin:0px;}
div.edited{
		font-size:10pt !important;
		top:30px;
		left:25px;
		width:410px;
		position:absolute;
		z-index: 10;
	}
div.page{
	page-break-after:always;
}
div.address{
	top:150px;
	left:550px;
	font-size:16pt;
	position:absolute;
}
div.permit{
	top:60px;
	left:848px;
	font-size:9px;
	position:absolute;
}
div.container{
	width: 2750px;
}
div.card{
	border:solid 1px;
	width:900px;
	height:600px;
	position:absolute;
}
div.card1{
	left:0px;
	top:0px;
}
div.card2{
	left:900px;
	top:0px;
}
div.card3{
	left:1800px;
	top:0px
}
div.card4{
	left:0px;
	top:600px;
}
div.card5{
	left:900px;
	top:600px;
}
div.card6{
	left:1800px;
	top:600px
}
div.card7{
	left:0px;
	top:1200px;
}
div.card8{
	left:900px;
	top:1200px;
}
div.card9{
	left:1800px;
	top:1200px
}
img.standard{
	width:900px;
}

</style>
@stop
@section('card')
<div class="container">
	<?php $g=0; ?>
	@for ($i = 1; $i <= $iterations; $i++)
		<div class="page">
		<?php if($i==$iterations){$k=$remainder;}else{$k=9;}?>
		@for($j=1; $j <= $k; $j++)
			<div class="card card{{$j}}">
				<div class="edited">
					{{$cards[$g]['back_text']}}
				</div>
				<div class="address">
					<p>Address Line 1</p>
					<p>Address Line 2</p>
					<p>City, Street</p>
				</div>
				<div class="permit">
					<p>Permit</p>
				</div>
				<img class="standard" src="{{URL::asset('assets/images/XpressCardsBlank.jpg')}}"></img>
			</div>
			<?php $g++; ?>>	
		@endfor
		</div> <!--End page-->
	@endfor
</div>
@stop
@section('footer')
<script>
	
</script>
@stop
