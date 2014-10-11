@extends('layout.main')
@section('header')
<style>
	.photo  {
  margin-bottom: 20px;
  float: left;
  position: relative;
  border-radius: 5px;
  background: white;
  padding: 5px;
  margin: 5px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
}
.photo:hover { 
	-moz-box-shadow: 0 0 15px #ccc; 
	-webkit-box-shadow: 0 0 15px #ccc; 
	 box-shadow: 0 0 15px #ccc; 
	}
.paginate {
  display: block;
  clear: both;
  margin: 10px;
  text-align: center;
  margin: 0 auto;
  padding: 20px 0;
  height: 100px;
}
</style>
<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="{{URL::asset('css/magnific/main.css')}}"> 
@stop
@section('addresses')
<div id='photo-mount' style="display:none;">
	<img id='photo-mount' class='mount' width='300' src=''/>
	{{Form::open(array('url' => URL::route('build-process'), 'method' => 'post'))}}
		<input type="hidden" name="src" value="" />
		<button class='btn btn-success'>Choose this photo</button>
	{{Form::close()}}
	
</div>
<div id="photos-wrap">
	@foreach($media['data'] as $image)	
	<div class='photo'>
	    <a data-standard_resolution='{{$image['source']}}' target='_blank' href="{{$image['source']}}">
				<img class='main' width="150" src="{{$image['picture']}}"/>	
		</a>
	</div>
    @endforeach	
</div>
<div class='paginate'>
	<a type='button' id="nextUrl" class='btn btn-primary' style='' data-next-url='{{$media['paging']['next']}}' href='#'>View More...</a>
</div>


@stop
@section('footer')
@if(isset($media))
<!-- Magnific Popup core JS file -->
<script src="{{URL::asset('js/magnific/magnific.min.js')}}"></script>
<script>
$(document).ready(function(){
  $('#photos-wrap').magnificPopup({
      delegate: 'a',
      type: 'image',
      tLoading: 'Loading image #%curr%...',
      mainClass: 'mfp-img-mobile',
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1] // Will preload 0 - before current, and 1 after the current image
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function(item) {
        		var html='<form action="{{URL::route("build-process")}}" method="POST">'
        		html +='<input type="hidden" name="src" value="'+item.el.attr('data-standard_resolution')+'"/>';
        		html += '{{Form::token()}}';
        		html += '<button class="btn btn-success" type="submit">Use this Photo</button>';
        		html += '</form>';
        		console.log(html);
              return html;
            }
      }
	});
  var nextButton = document.getElementById('nextUrl');
  var mount= $('#photo-mount').first();

  function generateResource(){
   url = "https://graph.facebook.com/v1/me/photos?access_token={{$user->facebook_token}}";
	}
 
  function toScreen(photos){
    var photos_html = '';
    console.log(photos);
	$('#nextUrl').attr('data-next-url',photos.paging.next);
    
    $.each(photos.data, function(index, photo){
    	photos_html += "<div class='photo'><a data-standard_resolution='"+photo.source+"' target='_blank' href='"+photo.source+"'><img class='main' width='150' src='"+photo.source+"'/></a></div>";
    });
     $('div#photos-wrap').append(photos_html);
     $(".main").bind("load", function () { $(this).fadeIn(); });
  }
  
  function fetchPhotos(next_url){
  	$.getJSON(next_url+"&access_token={{$user->facebook_token}}&callback=?",toScreen);
  }
  
  nextButton.addEventListener('click',function(event){
	 event.preventDefault();
      var next_url=$(this).attr('data-next-url');
      fetchPhotos(next_url); 
    });
    
    var n = $('.photo a').length;
    
    $('#photos-wrap').on('click','a',function(event){
    	event.preventDefault();
 		console.log('switch');
 		var standard=$(this).attr('data-standard_resolution')
 		mount.show();
 		mount.children('img').attr('src',standard);
 		$('input[name=src]').val(standard);
 		$('html, body').animate({
        scrollTop: mount.offset().top
    	}, 500);
    });
});
</script>
@endif
@stop

