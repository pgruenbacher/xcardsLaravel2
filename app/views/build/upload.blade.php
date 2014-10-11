@extends('layout.main')
@section('header')
<script src="{{URL::asset('js/jquery.form.min.js')}}"></script>
<style>
	.fileinput-button {
	  position: relative;
	  overflow: hidden;
	}
	.fileinput-button input {
	  position: absolute;
	  top: 0;
	  right: 0;
	  margin: 0;
	  opacity: 0;
	  -ms-filter: 'alpha(opacity=0)';
	  font-size: 200px;
	  direction: ltr;
	  cursor: pointer;
	}
	
	/* Fixes for IE < 8 */
	@media screen\9 {
	  .fileinput-button input {
	    filter: alpha(opacity=0);
	    font-size: 100%;
	    height: 100%;
	  }
	}
</style>
@stop
@section('addresses')
<div class="col-md-8">
    <div class="row">
        <div class="span8">
            <h4>Upload your Image</h4>
        </div>
    </div>
	<div>
		<div class="selection">
			<span class="btn btn-default fileinput-button">
		        <i class="fa fa-plus"></i>
		        <span id="fileinput-text">Select files...</span>
		        <!-- The file input field used as target for the file upload widget -->
		        <input id="fileupload" type="file" name="files">
		    </span>
		    <div id="continue" style="display:none">
		    	<form action="{{URL::route('build-process')}}">
		    		{{Form::token()}}
		    		<input id="src" type="hidden" name="src" value="">
		    		<button class="btn btn-success">Continue...</button>
		    	</form>
		    </div>
	 	</div><!--end selection-->
	    <br>
	    <br>
	    <!-- The global progress bar -->
	    <div class="progress progress-striped active">
			<div id="progress-bar" class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
				<span class="sr-only"></span>
			</div>
		</div>
	    <!-- The container for the uploaded files -->
	    <div id="files" class="files"></div>
	    <br>
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title">Upload Notes</h3>
	        </div>
	        <div class="panel-body">
	            <ul>
	                <li>The maximum file size for uploads is <strong>5 MB</strong></li>
	                <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed </li>
	                <li>You can <strong>drag &amp; drop</strong> files from your desktop </li>
	        	</ul>
	        </div>
	    </div>
	</div>
</div>
@stop
@section('footer')
<!--Jquery File Upload-->
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{URL::asset('js/upload/jquery.iframe-transport.js')}}"></script>
<!-- The basic File Upload plugin -->
<script src="{{URL::asset('js/upload/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/upload/jquery.fileupload-process.js')}}"></script>
<script src="{{URL::asset('js/upload/jquery.fileupload-validate.js')}}"></script>
<script>
/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var progressBar=$('#progress-bar');
    var url = '{{URL::route('upload-handler')}}';
    $('#fileupload').fileupload({
        url: url,
        maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        dataType: 'json',
        fail: function (e, data) {console.log(data); },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
            	console.log(data);
            	$('#files').empty();
                $('<p/>').text(file.name).appendTo('#files');
                $('<img src="'+file.thumbnailUrl+'"/>').appendTo('#files');
                $('#fileinput-text').text('Different File...');
                $('#continue').show();
                $('#src').val(file.url);
                $('div.progress').removeClass('progress-striped');
            });
        },
        progressall: function (e, data) {
        	$('div.progress').addClass('progress-striped');
            var progress = parseInt(data.loaded / data.total * 100, 10);
            progressBar.css('width', progress + '%');
            progressBar.attr('aria-valuenow',progress);
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>

@stop
