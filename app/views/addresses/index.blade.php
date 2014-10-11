@extends('layout.address-book')

@section('addresses')

@include('layout.address-nav')

<!-- will be used to show any messages -->
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<!--<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>User</td>
			<td>Addressee</td>
			<td>Email</td>
			<td>Address Line 1</td>
			<td>Address Line 2</td>
			<td>Actions</td>
		</tr>
	</thead>
	<tbody>
	@foreach($addresses as $key => $value)
		<tr>
			<td>{{ $value->user }}</td>
			<td>{{ $value->addressee }}</td>
			<td>{{ $value->email }}</td>
			<td>{{ $value->delivery_line_1 }}</td>
			<td>{{ $value->last_line }}</td>

			<!-- we will also add show, edit, and delete buttons -->
<!--			<td>

				<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
<!--				{{ Form::open(array('url' => 'address-book/' . $value->id, 'class' => 'pull-right')) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}

				<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
<!--				<a class="btn btn-small btn-success" href="{{ URL::to('address-book/' . $value->id) }}">Show</a>

				<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
<!--				<a class="btn btn-small btn-info" href="{{ URL::to('address-book/' . $value->id . '/edit') }}">Edit</a>

			</td>
		</tr>
	@endforeach
	</tbody>
</table> -->
<table id="address-book" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Addressee</th>
        <th>Email</th>
        <th>Address</th>
        <th>Actions</th>
   	</tr>
    </thead>
    <tbody>
    	
    </tbody>
</table>

<script type="text/javascript">
    var oTable;
    $(document).ready(function() {
	 	// Create the form
	    
	 
	    //Init Table
        oTable = $('#address-book').dataTable( {
        	"sPaginationType": "full_numbers",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "{{ URL::to('address-book/data') }}"
            });
       
     
    });
</script>
@stop
