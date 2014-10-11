@extends('layout.frontpage')

@section('header')
<style>
	.contact{
		padding-left:37.5px;
		
	}
</style>
@stop
@section('content')
<div class="row">
	<div class="col-md-7 contact">
			<h1>Contact Us</h1>
			<div class="panel panel-default">
				<div class="panel-heading">
					Our Office
				</div>
				<div class="panel-info">
					<address>
						<strong>X-Press Cards ltd</strong></br>
						2392 Indiana Ave</br>
						Columbus OH 43202</br>
					</address>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					Our Email
				</div>
				<div class="panel-body">
					<p>Information</p>
					<a href="mailto:info@x-presscards.com?subject=info">info@x-presscards.com</a>
					<p>Urgent</p>
					<a href="mailto:help@x-presscards.com?subject=help">help@x-presscards.com</a>
					<p>Media</p>
					<a href="mailto:media@x-presscards.com?subject=media">media@x-presscards.com</a>
					<div id="paul">
						<p>Paul Gruenbacher</p>
						<p>Technical Inquiries</p>
						<a href="mailto:paul@x-presscards.com?subject=media">paul@x-presscards.com</a>
					</div>
					<div id="john">	
						<p>John Gruenbacher</p>
						<p>Business Inquiries</p>
						<a href="mailto:john@x-presscards.com?subject=media">john@x-presscards.com</a>
					</div>
				</div>
			</div>
			
			
			<h2>Or just submit form</h2>
			@if(Session::has('global'))
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<p>{{Session::get('global')}}</p>
				</div>
			@endif
			<form action="{{URL::route('contact-post')}}" method="post" role="form">
				<div class="form-group">
					<label for="email">Your email</label>
					<input type="email" id="email" name="email" class="form-control" placeholder="subject" required/>
				</div>
				{{($errors->has('email')) ? $errors->first('email'):''}}
				<div class="form-group">
					<label for="subject">Subject</label>
					<select name="subject" id="subject" class="form-control">
					  <option value="info">Info</option>
					  <option value="media">Media</option>
					  <option value="help">Help</option>
					  <option value="career">Career</option>
					</select>
				</div>
				{{($errors->has('subject')) ? $errors->first('subject'):''}}
				<div class="form-group">
					<label for="text">Body</label>
					<textarea id="text" name="text" class="form-control" placeholder="enter text here..." required></textarea>
				</div>
				{{($errors->has('text')) ? $errors->first('text'):''}}
				{{Form::token()}}
				<button class="btn btn-default" type="submit">Send</button>
			</form>
		</div>
	<div class="col-md-5">
		<iframe
		  width="100%"
		  height="800px"
		  frameborder="0" style="border:0"
		  src="https://www.google.com/maps/embed/v1/search?key=AIzaSyAxlFWkjrrEW6lt2IBMdUQ8dQ_01bC0-lg&q=Ohio+State+University">
		</iframe>
	</div>
</div>
	

@stop
@section('footer')


@stop
