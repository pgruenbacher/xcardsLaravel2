@extends('layout.main')
@section('banner-title')
Write Message
@stop
@section('banner-instructions')
Write a message on the card
@stop
@section('header')
<script src="http://rangy.googlecode.com/svn/trunk/currentrelease/rangy-core.js"></script>
<script src="{{URL::asset('js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/jquery.quickflip.min.js')}}" type="text/javascript"></script>
<style>
	.quickflip-wrapper{
		position:relative;
		height:600px;
		width:900px;
	}
	button.quickFlipCta{
		position:absolute;
		left:45%;
	}
	div.form-submit{
	}
	div.image-card{
		position:relative;
		z-index: -10;
		border:1px solid;
		width:100%;
		height:100%;
	}
	div.editable{
		top:30px;
		left:25px;
		width:410px;
		position:absolute;
		z-index: 10;
	}
	div.editable2{
		top:30px;
		left:15px;
		right:15px;
		position:absolute;
		z-index:11;
	}	
	div.form{
		position:absolute;
		right:10px;
		z-index: 20;
	}
	.whiteOnSalmon{
		font-size:64px;
		padding: 4px 8px;
		background-color:#FFCC99;
		border-radius:4px;
		color:#ffffff;
		-moz-box-shadow: 5px 5px 5px #888;
		-webkit-box-shadow: 5px 5px 5px #888;
		box-shadow: 5px 5px 5px #888;
	}
	.festive{
		font-size:64px;
		font-family:Verdana, Geneva, sans-serif;
		 -webkit-text-stroke: 1px black;
	   color: #FF0000;
	   text-shadow:
	       3px 3px 0 #009900,
	     -1px -1px 0 #009900,  
	      1px -1px 0 #009900,
	      -1px 1px 0 #009900,
	       1px 1px 0 #009900;
	}
</style>
@stop
@section('addresses')
<div class="form form-submit">
	{{Form::open(array(
		'route'=>$nextRoute,
		'id'=>'card-form'
	))}}
	<input id="raw" name="raw_back_text" type="hidden" value=""/>
	{{Form::close()}}
	<button class="btn btn-success" id="submit">Submit</button>
</div>
<div class="quickflip-wrapper">
	<div class="panel1">
		<button class="btn btn-primary quickFlipCta">Flip <icon class="fa fa-refresh"></icon></button>
		<div class="editable" max-height="530">
			<p>{{isset($back_text) ? $back_text : 'Click on here to edit the text'}}</p>
		</div>
		<div class="image-card">
			<img width="100%" src="{{URL::asset('assets/images/XpressCardsBlank.jpg')}}"></img>
		</div>
	</div>
	<div class="panel2">
		<button class="btn btn-primary quickFlipCta">Flip <icon class="fa fa-refresh"></icon></button>
		<div class="editable2">
				<p>Add or edit headers if you want</p>
		</div>
		<div class="image-card">
			{{$card->renderImage()}}
		</div>
	</div>
</div><!--End QuickFlip-->
@stop
@section('footer')
<script type="text/javascript">
$(function() {
	    $('.quickflip-wrapper').quickFlip({
	    	refresh:true
	    });
	});
var max_height=$('div.editable').attr('max-height');
function alertMax(event){
	var height=$(this).height();
	if((height>max_height)&&(event.which!==46)&&(event.which!==8)){
		alert('You have extended past the card area!');
		tinymce.activeEditor.undoManager.undo();
	}
}
$('div.editable').on('keydown',alertMax);
$('div.editable2').on('keydown',alertMax);

tinymce.init({
    selector: "div.editable",
    inline: true,
    plugins: [],
    menubar:false,
    toolbar: "undo redo | bold italic | fontselect ",
    content_css:"{{URL::asset('css/tinyMCE/card.css')}}",
    style_formats:"",
});
tinymce.init({
    selector: "div.editable2",
    inline: true,
    plugins: [],
    menubar:false,
    toolbar: "undo redo | bold italic | styleselect",
    style_formats: [
        {title: 'Salmon', inline: 'span', classes:'whiteOnSalmon'},
        {title: 'Festive', inline: 'span', classes:'festive'},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: "Alignment", items: [
	        {title: "Left", icon: "alignleft", format: "alignleft"},
	        {title: "Center", icon: "aligncenter", format: "aligncenter"},
	        {title: "Right", icon: "alignright", format: "alignright"},
	        {title: "Justify", icon: "alignjustify", format: "alignjustify"}
    	]}

    ],

});

$('#submit').click(function(e){
	var raw=$('div.editable').html();
	var width=$('image-card').width();
	var height=$('image-card').height();
	$('#raw').val(raw);
	$('#height').val(height);
	$('#width').val(width);
	$('#card-form').submit();
})
</script>

@stop

