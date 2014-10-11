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
	font-size:13pt;
	position:absolute;
}
div.barcode{
	position:absolute;
	top:500px;
	left:550px;
}
div.permit{
	top:57px;
	left:800.6px;
	font-size:9px;
	position:absolute;
}
div.container{
	width: 2750px;
}
.frontImage, div.card{
	width:862px;
	height:562.5px;
	position:absolute;
	z-index:0;
}
div.table {
    display:block;
}
div.tr {
    display:block;
}
div.td {
    float:left;
    display:inline-block;
}
.rotated{
	transform-origin: 50% 50%;
}
div.frontImage3,div.card1{
	left:68.7px;
	top:68.7px;
}
div.frontImage2,div.card2{
	left:993.6px;
	top:68.7px;
}
div.frontImage1,div.card3{
	left:1918.5px;
	top:68.7px;
}
div.frontImage6,div.card4{
	left:68.7px;
	top:693.6px;
}
div.frontImage5,div.card5{
	left:993.6px;
	top:693.6px;
}
div.frontImage4,div.card6{
	left:1918.5px;
	top:693.6px;
}
div.frontImage9,div.card7{
	left:68.7px;
	top:1318.5px;
}
div.frontImage8,div.card8{
	left:993.6px;
	top:1318.5px;
}
div.frontImage7,div.card9{
	left:1918.5px;
	top:1318.5px;
}
img.standard{
	width:862px;
	height:562.5px;
}
img.cropMarks{
	z-index:100;
	position:absolute;
	top:-60px;
	left:-18px;
	width:900px;
	height:694.5px;
}


</style>
@stop

@section('card')
<div class="container">
	<?php $i=0; $k=1; ?>
	@foreach($cards as $card)
	<?php $j=0; $addresses=$card->Addresses()->get(); ?>
		@foreach($addresses as $address)
			<?php 
			$smarty=$address->smartyStreet()->first(); 
			 if($k==1){
				echo '<div class="page">';	
				 $flash=array();
			} 
			?>
			<div class="card card{{$k}}">
				<div class="edited">
					{{$cards[$i]['back_text']}}
				</div>
				<div class="address">
					<p>{{$address->addressee}}</p>
					<p>{{$smarty['delivery_line_1']}}</p>
					<p>{{$smarty['last_line']}}</p>
				</div>
				<div class="barcode">
					{{is_object($smarty)?$smarty->generateIBM():''}}
				</div>
				<div class="permit">
					<p>Permit</p>
				</div>
				<img class="standard" src="{{URL::asset('assets/images/XpressCardsBlank.jpg')}}"></img>
				<img class="cropMarks" src="{{URL::asset('assets/images/CropMarks_3-75_5-75.gif')}}"></img>
			</div>

			
				<?php array_push($flash,$i);?>		
				@if($k==9)
					<?php $k=1;?>
				</div>
				<div class="page">
					@foreach($flash as $l)
					<div class="frontImage frontImage{{$k}}">
						{{$cards[$l]->renderPDF(862,562.5)}}
						<img class="cropMarks" src="{{URL::asset('assets/images/CropMarks_3-75_5-75.gif')}}"></img>
					</div>
					<?php $k++; ?>
					@endforeach
					<?php $k=1; ?>
				</div><!--End Page-->
				
				@else
					<?php $j++; $k++; ?>
				@endif
			
	@endforeach
	
		<?php $i++; ?>
	@endforeach
	@if($k!=9)
		</div>
		<?php $k=1; ?>
		</div>
		<div class="page">
		@foreach($flash as $l)
		<div class="frontImage frontImage{{$k}}">
			{{$cards[$l]->renderPDF(862,562.5)}}
			<img class="cropMarks" src="{{URL::asset('assets/images/CropMarks_3-75_5-75.gif')}}"></img>
		</div>
		<?php $k++; ?>
		@endforeach
	
	@endif
</div><!--end page-->
@stop
