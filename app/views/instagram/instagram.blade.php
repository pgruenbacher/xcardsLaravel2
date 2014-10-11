@extends('layout.main')
@section('header')
<script type="text/javascript" src="{{URL::asset('js/underscore.js')}}"></script>
<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="{{URL::asset('css/magnific/main.css')}}"> 
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
.photo .avatar {
  width: 40px;
  height: 40px;
  padding: 2px;
  position: absolute;
  bottom: 11px;
  right: 8px;
  background: white;
}
.photo .heart {
  height: 16px;
  position: absolute;
  left: 13px;
  bottom: 16px;
  padding: 0 5px 0 22px;
  font-size: 12px;
  font-weight: bold;
  line-height: 16px;
  border-radius: 2px;
  border: 1px solid #ddd;
  background: white url('../images/fav.png') no-repeat 2px 0;
}

</style>
@stop
@section('addresses')

@if(isset($media))
<div id='photo-mount' style="display:none;">
	<img id='photo-mount' class='mount' width='300' height='300' src=''></img>
	{{Form::open(array('url' => URL::route('build-process'), 'method' => 'post'))}}
		<input type="hidden" name="src" value="" />
		<button class='btn btn-success'>Choose this photo</button>
	{{Form::close()}}
	
</div>
<div id="photos-wrap">
	@foreach($media->data as $image)	<div class='photo'>
    <a data-standard_resolution='{{$image->images->standard_resolution->url}}' data-low_resolution='{{$image->images->low_resolution->url}}' href='{{$image->images->low_resolution->url}}' target='_blank'>
			<img class='main' width="150" height="150" src="{{$image->images->thumbnail->url}}"></img>	
	</a>
	<img class='avatar' width='40' height='40' src='{{$image->user->profile_picture}}' />
    <span class='heart'><strong>{{$image->likes->count}}</strong></span>	
    </div>
    @endforeach	
</div>
<div class='paginate'>
	<a type='button' id="nextUrl" class='btn btn-primary' style='' data-next-url='{{$media->pagination->next_url}}' data-max-id='{{$media->pagination->next_max_id}}' href='#'>View More...</a>
</div>

<script type="text/template" id="photo-template">
  <div class='photo'>
    <a data-standard_resolution='<%= standard_resolution%>' data-low_resolution='<%= low_resolution %>' href='<%= low_resolution %>' target='_blank'>
      <img class='main' src='<%= photo %>' width='150' height='150' style='display:none;'/>
    </a>
    <img class='avatar' width='40' height='40' src='<%= avatar %>' />
    <span class='heart'><strong><%= count %></strong></span>
  </div>
</script>

@else
<a href='{{$instagram->getLoginUrl()}}'>Login with Instagram</a>
@endif

@stop
@section('footer')
<!-- Magnific Popup core JS file -->
<script src="{{URL::asset('js/magnific/magnific.min.js')}}"></script>
<script>
@if(isset($media))
$(document).ready(function(){
  console.log('script is started');
  console.log('{{$media->pagination->next_url}}');

  var photoTemplate = _.template($('#photo-template').html());
  var nextButton = document.getElementById('nextUrl');
  var mount= $('#photo-mount').first();

  function generateResource(max_id){
   url = "https://api.instagram.com/v1/users/{{$id}}/media/recent/?access_token={{$instagram->getAccessToken()}}";

  return function(max_id){
    if(typeof max_id === 'string' && max_id.trim() !== '') {
      url += "&max_id=" + max_id;
    }
    console.log(url);
    return url;
  };
 }
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
  function toScreen(photos){
    var photos_html = '';
    console.log(photos);
	$('#nextUrl').attr('data-next-url',photos.pagination.next_url);
    $('.paginate a').attr('data-max-id', photos.pagination.next_max_id).fadeIn();

    $.each(photos.data, function(index, photo){
    	photos_html += toTemplate(photo);
    });
     $('div#photos-wrap').append(photos_html);
     $(".main").bind("load", function () { $(this).fadeIn(); });
  }
  
  function fetchPhotos(max_id,next_url){
  	$.getJSON(next_url+"&callback=?",toScreen);
    //$.getJSON("https://api.instagram.com/v1/users/{{$id}}/media/recent/?access_token={{$instagram->getAccessToken()}}&callback=?&max_id="+max_id, toScreen);
  }
  
  function toTemplate(photo){
    photo = {
      count: photo.likes.count,
      avatar: photo.user.profile_picture,
      photo: photo.images.thumbnail.url,
      standard_resolution:photo.images.standard_resolution.url,
      low_resolution:photo.images.low_resolution.url
  };
	return photoTemplate(photo);
  }	
 	nextButton.addEventListener('click',function(event){
	 event.preventDefault();
      var maxID = $(this).attr('data-max-id');
      var next_url=$(this).attr('data-next-url');
      console.log(maxID);
      fetchPhotos(maxID,next_url); 
    });
    
    var n = $('.photo a').length;
    
    $('#photos-wrap').on('click','a',function(event){
    	event.preventDefault();
 		console.log('switch');
 		var low_resolution=$(this).attr('data-low_resolution');
 		var standard=$(this).attr('data-standard_resolution')
 		mount.show();
 		mount.children('img').attr('src',low_resolution);
 		$('input[name=src]').val(standard);
 		$('html, body').animate({
        scrollTop: mount.offset().top
    	}, 500);
    });
});

  
@endif
</script>

@stop
