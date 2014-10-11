@extends('layout.address-book')

@section('header')
<script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/2.4/jquery.liveaddress.min.js"></script>
@stop

@section('addresses')
<style>
	div.new {
    background-color: rgb(230,230,230);
    border-bottom: 1px dotted #ccc;
    display: none;
			}
	div.boundary{
		border:1px solid #ccc;
	}
	#initRow {
	position: relative;
}
	.rowDelete{
		margin-left:20px;
	}
 
	/*replace the content value with the
	corresponding value from the list below*/
 
	#initRow:before {
    content: "\f0a9";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
	/*--adjust as necessary--*/
    color: #000;
    font-size: 40px;
    padding-right: 2px;
    position: relative;
    top: 10px;
    left: 0;
	}
		
</style>

@include('layout.address-nav')


<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

<form class="form-inline" role="form" action="{{URL::to('address-book')}}" method="post">
  <section>
  	<div id="initRow">
  <div class="form-group">
    <label class="sr-only" for="addressee">Full Name</label>
    <input type="text" class="form-control" id="addressee" name="" placeholder="Enter Full Name">
  </div>
  <div class="form-group">
    <label class="sr-only" for="exampleInputEmail2">Email address</label>
    <input type="email" class="form-control" id="email" name="" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label class="sr-only" for="address">Address</label>
    <textarea class="form-control" id="address" name="" placeholder="Enter full address"></textarea>
  </div>
  </div>
  </section>
   <button type="submit" class="btn btn-default">Submit</button>
</form>
@stop

@section('footer')
<script>
var LiveAddress= $.LiveAddress({key:"{{Config::get('development/smarty.publishable_key')}}"},{submitVerify:"false"})	
var counter=0;
function addRow(section, initRow) {
    var newRow = initRow.clone().removeAttr('id').addClass('new new'+counter).find("input").val("").end().find("#address").attr("id","addrTb"+counter).end().insertBefore(initRow),
        deleteRow = $('<button type="button" tabindex="-1" class="rowDelete"><i class="fa fa-times fa-2x"></i></button>'),
        changeid=$(".new new"+counter).find("textarea").text( "border");
   newRow.find("#addressee").attr("name","addressee[]");
    newRow.find("#email").attr("name","email[]");
     newRow.find("#addrTb"+counter).attr("name","address[]");
     newRow
        .append(deleteRow)
        .on('click', 'button.rowDelete', function() {
            removeRow(newRow);
        })
        .slideDown(300, function() {
            $(this)
                .find('#addressee').focus();
        })
}
        
function removeRow(newRow) {
    newRow
        .slideUp(200, function() {
            $(this)
                .next('div:not(#initRow)')
                    .find('input').focus()
                    .end()
                .end()
                .remove();
        });
}

$(function () {
    var initRow = $('#initRow'),
        section = initRow.parent('section');
    
    initRow.on('focus', 'input', function() {
        addRow(section, initRow);
   //Need to figure out how to make the street fields into an array.
		LiveAddress.mapFields([{street: '#addrTb0'},{street: '#addrTb1'},{street: '#addrTb2'},{street: '#addrTb3'},{street: '#addrTb4'},{street: '#addrTb5'},{street: '#addrTb6'},{street: '#addrTb7'},{street: '#addrTb8'},{street: '#addrTb9'},{street: '#addrTb10'},{street: '#addrTb11'},{street: '#addrTb12'}]);
			counter +=1;
     });
});
</script>
@stop