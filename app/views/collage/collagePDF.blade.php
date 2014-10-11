<div class="table" style="width:{{$width}}px; height:{{$height}}px;">
	<div class="tr" style="height:{{$height/2}}px;">
		<div class="td" style="width:{{$width/3}}px;">
			<div class="image" style="width:100%; overflow:hidden; border:2px solid #ffffff; border-radius:5px;">
				<img style="{{$image1->width > $image1->height?'height:100%':'width:100%'}}; {{$orientation=='threeByTwo'?'transform-origin: 50% 50%; transform:rotate(90deg)':''}}" src="{{$image1->path}}"/>
			</div>
		</div>
		<div class="td" style="width:{{$width/3}}px; ">
			<div class="image" style="width:100%; overflow:hidden; border:2px solid #ffffff; border-radius:5px;">
				<img style="{{$image2->width > $image2->height?'height:100%':'width:100%'}}; {{$orientation=='threeByTwo'?'transform-origin: 50% 50%; transform:rotate(90deg)':''}}" src="{{$image2->path}}"/>
			</div>
		</div>
		<div class="td" style="width:{{$width/3}}px;">
			<div class="image" style="width:100%; overflow:hidden; border:2px solid #ffffff; border-radius:5px;">
				<img style="{{$image3->width > $image3->height?'height:100%':'width:100%'}}; {{$orientation=='threeByTwo'?'transform-origin: 50% 50%; transform:rotate(90deg)':''}}" src="{{$image3->path}}"/>
			</div>
		</div>
	</div>
	<div class="tr" style="height:{{$height/2}}px;">
		<div class="td" style="width:{{$width/3}}px; ">
			<div class="image" style="width:100%; overflow:hidden; border:2px solid #ffffff; border-radius:5px;">
				<img style="{{$image4->width > $image4->height?'height:100%':'width:100%'}}; {{$orientation=='threeByTwo'?'transform-origin: 50% 50%; transform:rotate(90deg)':''}}" src="{{$image4->path}}"/>
			</div>
		</div>
		<div class="td" style="width:{{$width/3}}px;">
			<div class="image" style="width:100%; overflow:hidden; border:2px solid #ffffff; border-radius:5px;">
				<img style="{{$image5->width > $image5->height?'height:100%':'width:100%'}}; {{$orientation=='threeByTwo'?'transform-origin: 50% 50%; transform:rotate(90deg)':''}}" src="{{$image5->path}}"/>
			</div>
		</div>
		<div class="td" style="width:{{$width/3}}px; ">
			<div class="image" style="width:100%; overflow:hidden; border:2px solid #ffffff; border-radius:5px;">
				<img style="{{$image6->width > $image6->height?'height:100%':'width:100%'}}; {{$orientation=='threeByTwo'?'transform-origin: 50% 50%; transform:rotate(90deg)':''}}" src="{{$image6->path}}"/>
			</div>
		</div>
	</div>
</div>
