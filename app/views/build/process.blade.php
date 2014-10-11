@extends('layout.main')
@section('banner-title')
Crop Image
@stop
@section('banner-instructions')
Crop and rotate your image
@stop
@section('header')

<link rel="stylesheet" type="text/css" href="{{URL::asset('css/jCrop/jquery.Jcrop.css')}}"></style>
<style>
	.jcrop-vline,.jcrop-hline{background:#FFF url({{URL::asset('css/jCrop/Jcrop.gif')}});font-size:0;position:absolute;}
	.jcrop-holder #preview-pane {
  display: block;
  position: absolute;
  z-index: 2000;
  top: 10px;
  right: -340px;
  padding: 6px;
  border: 1px rgba(0,0,0,.4) solid;
  background-color: white;

  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;

  -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
}
.preview-container {
  width: 300px;
  height: 200px;
  overflow: hidden;
}
.success:after{
	content:" \f00c";
	font-family:"FontAwesome";
	color:green;
}
</style>
@stop

@section('addresses')
	@if($errors->has('x1'))
	<h3>You need to crop the picture before we proceed</h3>
	@endif
<div class="original_image">
	<img src="{{$image['path']}}" id="target" />
</div>
@if($image['width']==$image['height'])
<div class="rotate">
	<button id="rotate-button" data-value="0">Rotate</button>
</div>
@else
<div class="rotate">
	<form id="rotate-form" action="{{URL::route('build-process')}}" method="get">
		<input type="hidden" name="image" value="{{$image['id']}}">
		<input type="hidden" name="rotate" value="90">
		<button type="submit">Rotate</button>
	</form>
</div>
@endif
<div id="card-type">
	<button class="btn" format-id="1" data-height="200" data-width="300" data-format="4x6">6x4 Card</button>
</div>
  <div id="preview-pane">
    <div class="preview-container" style="width:300px; height:200px;">
      <img id="preview-img" src="{{$image['path']}}" class="jcrop-preview" alt="Preview" />
    </div>
    <div class="previewNotification">
		<h2>Image Status</h2>
		<p>Original Image: <span id="originalMessage"></span></p>
		<p>Cropped Image: <span id="croppedMessage"></span></p>
    </div>
  </div>
 {{Form::open(array('route'=>'build-crop','id'=>'crop-form'))}}
 	<input id="rotate" name="rotate" type="hidden" value="0">
 	<input id="format" name="format" type="hidden" value="1">
 	<input id="id" name="id" type="hidden" value="{{$image['id']}}">
 	<input id="y1" name="y1" type="hidden" value="">
 	<input id="x1" name="x1" type="hidden" value="">
 	<input id="y2" name="y2" type="hidden" value="">
 	<input id="x2" name="x2" type="hidden" value="">
 	<input id="w" name="w" type="hidden" value="">
 	<input id="h" name="h" type="hidden" value="">
 {{Form::close()}}
 <button id="submit" class="btn btn-danger">Submit Picture</button>
 
@stop

@section('footer')
<script type="text/javascript" src="{{URL::asset('js/jQueryRotateCompressed.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('js/jCrop/jquery.JcropRotate.js')}}"></script>

<script type="text/javascript">
$(document).ready(function($){
    // Create variables (in this scope) to hold the API and image size
    var jcrop_api,
        boundx,
        boundy,
        dpi=300,
		croppedStatus=$('#croppedStatus'),
        // Grab some information about the preview pane
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),
		originalMessage=$('#originalMessage'),
		croppedMessage=$('#croppedMessage'),
        xsize = $pcnt.width(),
        ysize = $pcnt.height();
    $('#target').removeAttr('style');
    $('div.jcrop-holder div div img').removeAttr('style');
    var width={{$image['width']}};
    var height={{$image['height']}};
    $('#target').attr('style','width:'+width+'px; height:'+height+'px;');
    initJcrop();
    function initJcrop()
	{	
		xsize = $pcnt.width(),
        ysize = $pcnt.height();
        $('#target').Jcrop({
          boxWidth: 600,
		  truesize:[{{$image['width']}},{{$image['height']}}],
	      onChange: updatePreview,
	      onSelect: updatePreview,
	      aspectRatio: xsize / ysize
	    },function(){
	      // Use the API to get the real image size
	      var bounds = this.getBounds();
	      boundx = bounds[0];
	      boundy = bounds[1];
	      console.log(boundx);
	      console.log(boundy);
	      xsize = $pcnt.width(),
          ysize = $pcnt.height();
	      var initialx1=boundx/6;
	      var initialy1=boundy/6;
	      var initialx2=boundx-(boundx/6);
	      var initialy2=(initialx2-initialx1)*(ysize/xsize);
	      console.log(initialx1,initialy1,initialx2,initialy2);
	      this.animateTo([initialx1,initialy1,initialx2,initialy2])
	      // Store the API in the jcrop_api variable
	      jcrop_api = this;
	      // Move the preview into the jcrop container for css positioning
	      $preview.appendTo(jcrop_api.ui.holder);
	      //Update the original message holder
	      updateOriginal();
	    });
	    
	};
	
    
  $('#submit').click(function(e){
  	var selected=jcrop_api.tellSelect();
    var scaled=jcrop_api.tellScaled();
    $('#x1').val(selected.x);
    $('#y1').val(selected.y);
    $('#x2').val(selected.x2);
    $('#y2').val(selected.y2);
    $('#w').val(selected.w);
    $('#h').val(selected.h);
    $('#crop-form').submit();
  });

    function updatePreview(c)
    {
      if (parseInt(c.w) > 0)
      {
      	updateNotification();
        var rx = xsize / c.w;
        var ry = ysize / c.h;

        $pimg.css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
      }
    };
    //Add Event Listeners
    $('div.rotate').on('submit','#rotate-form',function(e){
    	jcrop_api.destroy();
    	//initJcrop();
    });
    var rotate=$('#rotate-button');
   	rotate.click(function(e){
   		value=rotate.attr('data-value')*1+90;
   		rotate.attr('data-value',value);
   		$("#preview-img").rotate({angle:value});
		$("#target").rotate({angle:value});
		jcrop_api.destroy();
		initJcrop();
		$('div.jcrop-holder div div img').rotate({angle:value});
		$('#rotate').val(value);
  	});
	$('#card-type').on('click','button',function(e){
		var format=$(this).attr('format-id');
		$('#format').val(format);
		var width=$(this).attr('data-width');
		var height=$(this).attr('data-height');
		var container=$('#preview-pane .preview-container');
		container.css('width',width);
		container.css('height',height);
		jcrop_api.destroy();
		initJcrop();
		var value=$('#rotate-button').attr('data-value')*1;
		$('div.jcrop-holder div div img').rotate({angle:value});
	});
	
	function dpiCheck(w,h,dimensions){
		var data,
		minimumw=dimensions[0]*dpi, //4 inches * 300 dpi
		minimumh=dimensions[1]*dpi; //3 inches * 300 dpi
			if(w > minimumw && h > minimumh){
				data={status:true,message:'Cropped area satisfactory'};
			}else{
				data={status:false,message:'Cropped area not large enough'};
			}
		return data;
	}
	
	function updateNotification(){
		var data=dpiCheck(jcrop_api.tellSelect().w,jcrop_api.tellSelect().h,[{{$card->cardSetting()->first()->width}},{{$card->cardSetting()->first()->height}}]);
		croppedMessage.toggleClass('success',data.status).html(data.message);
	}
	function updateOriginal(){
		var bounds=jcrop_api.getBounds();
		var data=dpiCheck(bounds[0],bounds[1],[{{$card->cardSetting()->first()->width}},{{$card->cardSetting()->first()->height}}]);
		originalMessage.toggleClass('success',data.status).html(data.message);
	}
});
  
  
</script>

@stop
