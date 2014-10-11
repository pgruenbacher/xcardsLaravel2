@extends('layout.main')
@section('header')
<script type="text/javascript" src="{{URL::asset('js/underscore.js')}}"></script>
<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="{{URL::asset('css/magnific/main.css')}}"> 
<style>

div.scrollable{
	overflow-x:auto;
	overflow-y:hidden;
	white-space:nowrap;
}
div.scrollable>div>*{
	display:inline-block;
	*display:inline;
}
div.sectionArea{
	float:left;
	position:relative;
}
div.image{
	overflow:hidden;
	border:2px solid #2C3E50;
	border-radius:5px;
}
.cardImage{
	width:100%;
}
.btn-submit{
	display:none;
}
#selectTemplates button{
	margin-bottom:15px;
}
#selectTemplates button img{
	
}
div.background {
	position:absolute;
	z-index:-1;
	top:0px;
	left:0px;
	right:0px;
	bottom:0px;
	margin:0px;
	text-align:center;
	font-size:18px;
   color:gray;
   background: #e5e5e5; /* Old browsers */
	background: -moz-radial-gradient(center, ellipse cover,  #e5e5e5 0%, #afafaf 88%); /* FF3.6+ */
	background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,#e5e5e5), color-stop(88%,#afafaf)); /* Chrome,Safari4+ */
	background: -webkit-radial-gradient(center, ellipse cover,  #e5e5e5 0%,#afafaf 88%); /* Chrome10+,Safari5.1+ */
	background: -o-radial-gradient(center, ellipse cover,  #e5e5e5 0%,#afafaf 88%); /* Opera 12+ */
	background: -ms-radial-gradient(center, ellipse cover,  #e5e5e5 0%,#afafaf 88%); /* IE10+ */
	background: radial-gradient(ellipse at center,  #e5e5e5 0%,#afafaf 88%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e5e5', endColorstr='#afafaf',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

}
div.background img{
	width:100%;
	max-height:100%;
}
.drop-hover .background{
	background: #fcfcfc; /* Old browsers */
	background: -moz-radial-gradient(center, ellipse cover,  #fcfcfc 0%, #dddddd 100%); /* FF3.6+ */
	background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,#fcfcfc), color-stop(100%,#dddddd)); /* Chrome,Safari4+ */
	background: -webkit-radial-gradient(center, ellipse cover,  #fcfcfc 0%,#dddddd 100%); /* Chrome10+,Safari5.1+ */
	background: -o-radial-gradient(center, ellipse cover,  #fcfcfc 0%,#dddddd 100%); /* Opera 12+ */
	background: -ms-radial-gradient(center, ellipse cover,  #fcfcfc 0%,#dddddd 100%); /* IE10+ */
	background: radial-gradient(ellipse at center,  #fcfcfc 0%,#dddddd 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfcfc', endColorstr='#dddddd',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
div.templateArea{
	-webkit-box-sixing: border-box;
    -moz-box-sizing: border-box; 
    box-sizing: border-box;
}
.photo  {
  margin-bottom: 20px;
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

<div class="row">
	<div class="col-md-12 inline">
		<div class="scrollable">
			<div id="photos-wrap">
			@foreach($media->data as $image)	
			<div class='photo'>
			   	<img data-standard_resolution='{{$image->images->standard_resolution->url}}' data-low_resolution='{{$image->images->low_resolution->url}}' class='main draggable' width="150" height="150" src="{{$image->images->thumbnail->url}}"></img>	
				<img class='avatar' width='40' height='40' src='{{$image->user->profile_picture}}' />
			    <span class='heart'><strong>{{$image->likes->count}}</strong></span>	
		    </div>
		    @endforeach	
		   </div>
		</div>
		<div class='paginate'>
			<a type='button' id="nextUrl" class='btn btn-primary' style='' data-next-url='{{$media->pagination->next_url}}' data-max-id='{{$media->pagination->next_max_id}}' href='#'>View More...</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8 pull-right">
		<div id="mountDrop" class="mount">
		
		</div>
	</div>
	<div class="col-md-4">
		<h2>Choose template, then drag and drop your images</h2>
		{{Form::open(array('url' => URL::route('instagram-process'), 'id'=>'instagram-form', 'method' => 'post'))}}
			<input type="hidden" name="image1" value="" />
			<input type="hidden" name="image2" value="" />
			<input type="hidden" name="image3" value="" />
			<input type="hidden" name="image4" value="" />
			<input type="hidden" name="image5" value="" />
			<input type="hidden" name="image6" value="" />
			<input type="hidden" name="orientation" value="" />
			<button class='btn btn-submit btn-success'>Continue...</button>
		{{Form::close()}}
			<div class="row">
				<script>
					JSONtemplate={
						twoThree:{perimeterWidth:400,perimeterHeight:266.67,widthPercent:33.333,heightPercent:50,type:'twoByThree'},
						threeTwo:{perimeterWidth:200,perimeterHeight:300,widthPercent:50,heightPercent:33.333,type:'threeByTwo'}
					};
				</script>
				<div id="selectTemplates">
					<button id="2x3" data-template="twoThree" class="btn btn-lg btn-info"><img src="{{URL::asset('assets/images/2x3template.gif')}}"/> 2x3 Landscape</button>
					<button id="3x2" data-template="threeTwo" class="btn btn-lg btn-info"><img src="{{URL::asset('assets/images/3x2template.gif')}}"/> 3x2 Portrait</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/template" id="photo-template">
  <div class='photo'>
    <img data-standard_resolution='<%= standard_resolution%>' data-low_resolution='<%= low_resolution %>' class='main draggable' src='<%= photo %>' width='150' height='150' style='display:none;'/>
    <img class='avatar' width='40' height='40' src='<%= avatar %>' />
    <span class='heart'><strong><%= count %></strong></span>
  </div>
</script>
<script type="text/template" id="mount-template">
  <div class="templateArea" style="width:<%= perimeterWidth %>px; height:<%= perimeterHeight %>px;">
  	<div class="sectionArea droppable" style="width:<%= widthPercent %>%; height:<%= heightPercent %>%;">
  		<div class="image"></div>
  		<div class="background" number="1">#1 Drag Here<img src="{{URL::asset('assets/images/ImageIcon.gif')}}"/></div>
  	</div>
  	<div class="sectionArea droppable" style="width:<%= widthPercent %>%; height:<%= heightPercent %>%;">
  		<div class="image"></div>
  		<div class="background" number="2">#2 Drag Here<img src="{{URL::asset('assets/images/ImageIcon.gif')}}"/></div>
  	</div>
  	<div class="sectionArea droppable" style="width:<%= widthPercent %>%; height:<%= heightPercent %>%;">
  		<div class="image"></div>
  		<div class="background" number="3">#3 Drag Here<img src="{{URL::asset('assets/images/ImageIcon.gif')}}"/></div>
  	</div>
  	<div class="sectionArea droppable" style="width:<%= widthPercent %>%; height:<%= heightPercent %>%;">
  		<div class="image"></div>
  		<div class="background" number="4">#4 Drag Here<img src="{{URL::asset('assets/images/ImageIcon.gif')}}"/></div>
  	</div>
  	<div class="sectionArea droppable" style="width:<%= widthPercent %>%; height:<%= heightPercent %>%;">
  		<div class="image"></div>
  		<div class="background" number="5">#5 Drag Here<img src="{{URL::asset('assets/images/ImageIcon.gif')}}"/></div>
  	</div>
  	<div class="sectionArea droppable" style="width:<%= widthPercent %>%; height:<%= heightPercent %>%;">
  		<div class="image"></div>
  		<div class="background" number="6">#6 Drag Here<img src="{{URL::asset('assets/images/ImageIcon.gif')}}"/></div>
  	</div>
  </div>
</script>
<script type="text/template" id="cardImage-template">
   	<img class="cardImage" src="<%= src %>" />
</script>


@else
<a href='{{$instagram->getLoginUrl()}}'>Login with Instagram</a>
@endif

@stop
@section('footer')
<!-- Magnific Popup core JS file -->
<script>
@if(isset($media))
$(document).ready(function(){
	  console.log('script is started');

	  var photoTemplate = _.template($('#photo-template').html());
	  var mountTemplate= _.template($('#mount-template').html());
	  var cardImageTemplate=_.template($('#cardImage-template').html());
	  var nextButton = document.getElementById('nextUrl');
	/*Drag and Drop Gallery */
	function initDrag(){
		$( ".draggable" ).draggable({ 
			revert: true, 
			revertDuration:5,
			containment:"window",
			helper:'clone',
			appendTo:'body' 
		});
	}

	initDrag();
	function initDrop(){
		$('div.droppable').droppable({
			accept:'.draggable',
			hoverClass:"drop-hover",
			drop: function (e, ui) {
				var src=ui.draggable.attr("data-low_resolution");
				var standard=ui.draggable.attr("data-standard_resolution");
	            var html=toCardPhotoTemplate(src);
	            var number=$(this).find('div.background').attr('number');
  				$(this).find('div.image').html(html);
  				if(checkFinish()){
  					$('.btn-submit').show();
  				}
  				$('#instagram-form').find('input[name="image'+number+'"]').val(standard);
	        }
	        
			
		})
	}
		


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
 
  function checkFinish(){
  	var count=0;
  	$('div.image').each(function(){
  		if($(this).children('img').length>0){
  			count++;
  		}
  		console.log(count);
  		
  	});
  	if(count==6){
  		return true;
  	}else{
  		return false;
  	}
  }
  function toScreen(photos){
    var photos_html = '';
    console.log(photos);
	$('#nextUrl').attr('data-next-url',photos.pagination.next_url);
    $('.paginate a').attr('data-max-id', photos.pagination.next_max_id).fadeIn();

    $.each(photos.data, function(index, photo){
    	photos_html += toTemplate(photo);
    });
     $('#photos-wrap').append(photos_html);
     $(".main").bind("load", function () { $(this).fadeIn(); });
     $("div.scrollable").scrollLeft($("div.scrollable")[0].scrollWidth);
     initDrag();
  }
  function toMount(JSONtemplate){
  	html=toMountTemplate(JSONtemplate);
  	$('#mountDrop').html(html);
  	$('#instagram-form').find('input[name="orientation"]').val(JSONtemplate['type']);
  	initDrop();
  }

  function fetchPhotos(max_id,next_url){
  	$.getJSON(next_url+"&callback=?",toScreen);
    //$.getJSON("https://api.instagram.com/v1/users/{{$id}}/media/recent/?access_token={{$instagram->getAccessToken()}}&callback=?&max_id="+max_id, toScreen);
  }
  
  function toMountTemplate(template){
  	template={
  		perimeterWidth:template.perimeterWidth,
  		perimeterHeight:template.perimeterHeight,
  		widthPercent:template.widthPercent,
  		heightPercent:template.heightPercent
  	};
  	return mountTemplate(template);
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
  function toCardPhotoTemplate(src){
  	data={
  		src: src
  	}
  	return cardImageTemplate(data);
  }
 	nextButton.addEventListener('click',function(event){
	 event.preventDefault();
      var maxID = $(this).attr('data-max-id');
      var next_url=$(this).attr('data-next-url');
      console.log(maxID);
      fetchPhotos(maxID,next_url); 
   });
    var n = $('.photo a').length;
    
    $('#selectTemplates').on('click','button',function(){
    	var id=$(this).attr('data-template');
    	toMount(JSONtemplate[id]);
    	console.log(JSONtemplate[id]);
    });
});

  
@endif
</script>

@stop
