@extends('layout.main')
@section('header')
<style>
	#table-head{margin-bottom:0px;}
	.bodycontainer { max-height: 350px; width: 100%; margin: 0; overflow-y: auto; }
	.table-scrollable { margin: 0; padding: 0; }
	tr.selected{background-color:#66CCFF;}
	.inline .inline-block{display:inline-block;}
	.inline .control-label{margin-left:10px;}
</style>
@stop
@section('addresses')
<div class="container">
	<h1>Share Credits and Addresses</h1>
	<h3>Enter email of person you would like to share your credits or addresses with</h3>
	<div class="row">
		<div class="col-md-12">
			<form action="{{URL::route('exchange')}}" method="POST" class="form-horizontal" role="form" id="exchangeForm">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="email" class="control-label">Email</label>
							<input id="email" class="form-control" type="email" placeholder="email" name="email"/>
							{{($errors->has('email')) ? $errors->first('email'):''}}
						</div>
						<div id="name" class="form-group">
							<label for="name" class="control-label">Name of person to share to</label>
							<input id="name" class="form-control" type="text" placeholder="full name" name="name"/>
							{{$errors->has('name')?$errors->first('name'):''}}
						</div>
						
						
					</div>
					<div class="col-md-6">
						<div class="well pull-right">
							<p>If the person already has an account, we'll go ahead and share</p>
							<p>Otherwise, we'll send an email to direct the person to make an account</p>
							<p>In either case, we'll send you an email notifying when the person accepts your exchange</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group form-group-inline">
							<label for="credits-send" class="control-label col-sm-8">Send Credits</label>
							<div class="col-sm-4">
								<input id="credits-send" type="checkbox" class="form-control" name="creditCheck"/>
							</div>
						</div>
						<div class="form-group form-group-inline">
							<label for="addresses-send" class="control-label col-sm-8">Share Addresses</label>
							<div class="col-sm-4">
								<input id="addresses-send" type="checkbox" class="form-control" name="addressCheck"/>
							</div>
						</div>
						<button class="btn btn-lg btn-default" type="submit">Submit</button>
					</div>
					<div class="col-md-8">
						<div class="form-group inline" id="credit-group" style="display:none">
							<label for="credits" class="control-label inline-block">Credits to share</label>
							<input id="credits" class="inline-block" name="credits" placeholder="# of credits"/>
							<p class="inline-block">Available credits: <span id="creditTicker" style="color:red">{{Auth::user()->credits}}</span></p>
						</div>
						{{$errors->has('credits') ? $errors->first('credits'):''}}
						{{$errors->has('addresses') ? $errors->first('addresses'):''}}
						<div class="form-group" id="addresses-group" style="display:none">
							<label for="addresses" class="control-label">Addresses</label>
							<div class="table-responsive">
								<div class="table-head">
									<table id="table-head" class="table table-bordered table-condensed table-sriped">
										<thead>
											<tr>
												<th>Name</th>
												<th>Address</th>
											</tr>
										</thead>
									</table>
								</div>
								<div class="bodycontainer scrollable">
									<table class="table table-body table-bordered table-condensed table-sriped table-scrollable">
										<tbody>
											@foreach($addresses as $address)
											<tr>
												<td>{{$address['addressee']}}</td>
												<td>{{$address['address']}}</td>
												<td style="display:none"><input type="checkbox" value="{{$address['id']}}" name="addresses[]"/></td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>
@stop
@section('footer')
<script>
$('#addresses-send').prop('checked', false);
$('#credits-send').prop('checked', false);
$('table.table-body > tbody > tr').each(function(){
	$(this).find('input').prop('checked',false);
});
$(':checkbox:checked').prop('checked',false);
$(document).ready(function () {
	var ticker=$('#creditTicker');
	var initial=parseInt(ticker.html());
	$('#credits').spinner({
		max:{{Auth::user()->credits}},
		min:0,
		decimals:0,
		change:function(event,ui){
			var value=$(this).spinner('value');
			ticker.html(value);
		},
		stop:function(event,ui){
			var value=$(this).spinner('value');
			ticker.html(initial-value);
		}
	});
	function updateTicker(value){
		var value=$(this).spinner('value');
		ticker.html(initial-value);
	}
	 $('#exchangeForm').on('change', '#credits-send', function(e) {
	    $('#credit-group').toggle();
	});
	$('#exchangeForm').on('change', '#addresses-send', function(e) {
	    $('#addresses-group').toggle();
	});
	$('table.table-body').on('click','tr',function(e){
		console.log('click');
		$(this).toggleClass('selected');
		var checkBox = $(this).find('input');
		console.log(checkBox);
        checkBox.prop("checked", !checkBox.prop("checked"));
	});
  //called when key is pressed in textbox
  $("#credits").keyup(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
     	console.log('clear');
  	    $("#credits")
  	    	.val('')
	        .popover({ content: "Only number" })
	        .blur(function () {
	            $(this).popover('hide');
        	});
		}else{
		}
	});
	$('#email').blur(function(e){
		console.log('blur');
		var dataString={email: $('#email').val()};
        $.ajax({
	        type: "POST",
	        url: "{{URL::to('validation')}}",
	        data: dataString,
	        dataType: "json",
	        success: function(data) {
          		popMessage(data);
        	} 
        });      
	});
	var content="";
	var title="";
	var inputName=$('input#name');
	function popMessage(data){
		if (data.exists){
			title='User exists';
			content='we\'ll simply transfer the credits after their approval';
			inputName.val(data.name);
			inputName.prop('readonly', true);
		}else{
			title='That user doesn\'t exist!';
			content='we\'ll send an email to the person to guide though account creation';
			inputName.val('');
			inputName.prop('readonly', false);
		}
		$('#email').popover({
			trigger:'manual',
			content:function(){
				return content;
			},
			title:function(){return title;},
			placement:'top'
		});
		$('#email').popover('show');
	}
});
</script>

@stop
