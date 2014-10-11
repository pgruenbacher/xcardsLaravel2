@extends('layout.main')
@section('banner-title')
Choose Recipients
@stop
@section('banner-instructions')
Choose from existing addresses, or manually add
@stop
@section('header')
<style>
td input{border: none; background: transparent;}
#address-book-head{margin-bottom:0px;}
.id{display:none;}
.email{display:none;}
.even{background-color:#F7FBFF;}
.odd{background-color:#D6EBFF;}
.addressee{	width:40%;}
.email{display:none;};
.address{width:55%;}
.select{width:5%;}
.bodycontainer { max-height: 450px; width: 100%; margin: 0; overflow-y: auto; }
.table-scrollable { margin: 0; padding: 0; }
tr.selected{background-color:#66CCFF;}
tr.even:not(.selected):hover{background-color:#85FFD6}
tr.odd:not(.selected):hover{background-color:#85FFD6}
#add{margin-left:18px;}
span.number{font-weight:600;}
</style>
@stop
@section('account')

@stop
@section('addresses')
<div class="row">
	<div class="col-md-5 pull-right">
		<div id="selected">
			<h3>Selected Recipients</h3>
			<h4>Number of Cards:<span class="number">{{(isset($selected)?count($selected):'0')+count($pet)}}</span></h4>
			@if(isset($pet))
			<h2>You're sending a card to: {{$pet->name}}</h2>
			<img src="{{URL::asset('assets/images/'.$pet->image)}}"/>
			@endif
			<Form method="POST" action="{{URL::route($nextRoute)}}">
				<table class="table table-condensed table-hover">
				<tbody class="selected">
						<!--Append Selection Here-->
						@if(isset($selected))
							@foreach($selected as $select)
							<tr>
								<td class="id"><input name="id[]" readonly value="{{$select['id']}}"/></td>
								<td><input readonly="readonly" value="{{$select['addressee']}}"/></td>
								<td class="email"><input readonly="readonly" value="{{$select['email']}}"/></td>
								<td><input readonly="readonly" value="{{$select['address']}}"/></td>
								<td><a class="btn"><i class="fa fa-times"></i></a></td>
							</tr>
							@endforeach
						@endif
				</tbody>
				</table>
				<input id="number" type="hidden" name="number" value="0"/>
				<button class="btn btn-primary" type="submit">Finish</button>
			</form>
		</div>
	</div>
	@if(! $pet)
	<div class="col-md-7">
		<div id="createForm">
			<h3>You can add an address you know...</h3>
			<form class="form-inline">
				<div class="form-group">
					<input class="form-control" id="name" placeholder="Enter Name of a person" value=""/>
				</div>
				<div class="form-group">
					<input class="form-control" id="email" placeholder="Enter email (optional)" value=""/>
				</div>
				<div class="form-group">
						<textarea class="form-control" name="address" id="address" placeholder="Enter address to send to" value=""></textarea>
				</div>
			</form>
			<button id="add">Add recipient</button>
		</div>
		<h3>Or select from your Addresses</h3>
		<p>
			<label for="search">
				<strong>Search </strong>
			</label>
			<input type="text" id="search"/>
		</p>
		<div class="table-head">
			<table id="address-book-head" class="table table-bordered table-condensed table-sriped">
			    <thead>
				    <tr>
				    	<th class="id">Id</th>
				        <th class="addressee">Addressee</th>
				        <th class="email">Email</th>
				        <th class="address">Address</th>
				        <th class="select">Select</th>
				  	</tr>
			    </thead>
			</table>
		</div>
	   <div class="bodycontainer scrollable">
		   <table id="address-book-body" class="table table-bordered table-condensed table-sriped table-scrollable">
			    <tbody class="selectable">
			    	<?php $i=0; ?>
			    	@foreach($data as $address)
			    	<tr class="<?php $result= ($i%2)==0 ? 'even':'odd';echo $result;?>">
			    		<td class="id">{{$address['id']}}</td>
			    		<td class="addressee">{{$address['addressee']}}</td>
			    		<td class="email">{{$address['email']}}</td>
			    		<td class="address">{{$address['address']}}</td>
		    		</tr>
					<?php $i++ ?>
			    	@endforeach
			    </tbody>
			</table>
		</div>
	</div>
</div><!--End Row-->
@endif
@stop
@section('footer')
<script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/2.4/jquery.liveaddress.min.js"></script>
<script>
var LiveAddress= $.LiveAddress({key:"{{Config::get('development/smarty.publishable_key')}}"},{submitVerify:"false"})	

   $(document).on('ready',function(){
   		var tableSelected = $('tbody.selected');
   		var createForm=$('#createForm');
   		var tableSelectFrom=$('#address-book-body');
   		var numberIndicator=$('span.number');
   		var numberInput=$('#number');
   		
   		
   		if(tableSelected.find('tr').length)
		{	
			tableSelected.find('tr').each(function(index,row1){
				id=$(row1).find('input[name="id[]"]').val();
			 	tableSelectFrom.find('td.id').each(function(index,row){
					html=$(row).text();
					if(html==id){
						$(row).parent().addClass('selected');
						return false;
					}
				});
   			});
   		}
   	
   		$('#search').keyup(function()
		{
			searchTable($(this).val());
		});	
		function searchTable(inputVal)
		{
			var table = tableSelectFrom;
			table.find('tr').each(function(index, row)
			{
				var allCells = $(row).find('td');
				if(allCells.length > 0)
				{
					var found = false;
					allCells.each(function(index, td)
					{
						var regExp = new RegExp(inputVal, 'i');
						if(regExp.test($(td).text()))
						{
							found = true;
							return false;
						}
					});
					if(found == true)$(row).show();else $(row).hide();
				}
			});
		}
		$('tbody.selectable').on('click','tr',function(){
			if(! $(this).hasClass('selected')){
				$(this).addClass('selected');
				var number=numberIndicator.html();
				number=number*1+1;
				numberIndicator.html(number);
				numberInput.val(number);		
				var id=$(this).find('td.id').html();
				var name=$(this).find('td.addressee').html();
				var email=$(this).find('td.email').html();
				var address=$(this).find('td.address').html();
				var listItem='<tr>';
				listItem+='<td class="id"><input name="id[]" readonly value="'+id+'"/></td>';
				listItem+='<td><input readonly="readonly" value="'+name+'"/></td>';
				listItem+='<td class="email"><input readonly="readonly" value="'+email+'"/></td>';
				listItem+='<td><input readonly="readonly" value="'+address+'"/></td>';
				listItem+='<td><a class="btn"><i class="fa fa-times"></i></a></td>';
				listItem+='</tr>';
				$(listItem).appendTo(tableSelected).hide().fadeIn(300);
			}
			
		});
		$("#createForm").on('click','button',function(){
			console.log('clicked');
			var name=$("#name").val();
			var email=$("#email").val();
			var address=$("#address").val();
			var number=numberIndicator.html();
			number=number*1+1;
			numberIndicator.html(number);
			numberInput.val(number);
			var listItem='<tr>';
				listItem+='<td class="id"></td>';
				listItem+='<td><input name="addressee[]" readonly="readonly" value="'+name+'"/></td>';
				listItem+='<td class="email"><input name="email[]" readonly="readonly" value="'+email+'"/></td>';
				listItem+='<td><input name="address[]" readonly="readonly" value="'+address+'"/></td>';
				listItem+='<td><a class="btn"><i class="fa fa-times"></i></a></td>';
				listItem+='</tr>';
			$(listItem).appendTo(tableSelected).hide().fadeIn(300);
		});
		
		$('tbody.selected').on('click','tr',function(){
			var id=$(this).find('input[name="id[]"]').val();
			$(this).remove();
			if(id!=''){
				var number=numberIndicator.html();
				number=number*1-1;
				numberIndicator.html(number);
				numberInput.val(number);
				var html='';
				tableSelectFrom.find('td.id').each(function(index,row){
					html=$(row).text();
					if(html==id){
						$(row).parent().removeClass('selected');
						return false;
					}
				});
			}
			
		});
			
   	
   });

</script>
@stop
