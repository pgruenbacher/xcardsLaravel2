@extends('layout.main')
@section('header')
<style>
	 table td{ padding: 2px 0; }
	 input
  {
    width: 100%;
    padding: 10px;
    margin: 0px;
    border: 1px solid #CCC;
  }
  .cs_import {
    padding: 10px 15px;
    background: #4479BA;
    color: #FFF;
}
.add_email {
    padding: 10px 15px;
    background: #CC3300;
    color: #FFF;
}

</style>
@stop
@section('addresses')
@include('layout.address-nav')
<h1>Request Addresses From Your Friends and Family</h1>
<!-- Any link with a class="cs_import" will start the import process -->
<a class="cs_import">Import your Email</a>
<a class="add_email" href="#">Insert a Email</a>

<form id="address-request-form" action="{{URL::route('request-address-post')}}" method="post">
<!-- This textarea will be populated with the contacts returned by CloudSponge -->
<textarea style="display:none;" name="contacts" id="contact_list" style="width:450px;height:82px"></textarea>
	
		@if(isset($contacts))
		<h4>Wait! Our database already has these addreses for these emails</h4>
	<table id="checkTable" class="table table-condensed">
		<thead class="check"><tr><th>Email</th><th>Address</th><th>Use this Address?</th></tr></thead>
		@foreach($check as $contact)
			<tr><td class="checkEmail">{{$contact['email']}}</td><td data-id="{{$contact['id']}}">{{$contact['address']}}</td><td><a class="btn useThis"><i class="fa fa-question"></i></a></td></tr>
		@endforeach
	</table>
	<table id="contacts" class="table table-condensed">
		<h4>Now go ahead and send the rest of the emails</h4>
		<thead class="contacts"><tr><th>Name</th><th>Email</th><th>Cancel</th></tr></thead>
		<?php $i=0; ?>
			@foreach($contacts['email'] as $email)
				<tr><td><input name="name[]" value="{{$contacts['name'][$i]}}"/></td><td><input name="email[]" value="{{$email}}"/></td><td><button class="deleteRowButton"><i class="fa fa-times"></i></button></td></tr>
				<?php $i++; ?>
			@endforeach
		</table>
		<input type="hidden" name="goAhead" value="true"/>
		@else
<table id="contacts" class="table table-condensed">
</table>
		@endif
<button>Send Emails</button>


@stop
@section('footer')
<!-- Set your options, including the domain_key -->
<script type='text/javascript'>
//The textarea_id for where the addresses are listed. 
var textarea_id='contact_list';
// these values will hold the owner information
var owner_email, owner_first_name, owner_last_name;
var appendInTextarea = true; // whether to append to existing contacts in the textarea
var appendInList = true;
var data={'name':[],'email':[]};
var emailSep = ", "; // email address separator to use in textarea
var tableElement=$('#contacts')
function populateTextarea(contacts, source, owner) {
	var contact, name, email, entry;
	var emails = [];
	var textarea = document.getElementById(textarea_id);
	// preserve the original value in the textarea
	if (appendInTextarea && textarea.value.strip().length > 0) {
		emails = textarea.value.split(emailSep);
	}
	
 
	// format each email address properly
	for (var i = 0; i < contacts.length; i++) {
	contact = contacts[i];
	name = contact.fullName();
	email = contact.selectedEmail();
		if(contact.address.hasOwnProperty("address")){
			console.log(contact.address);
		}
		entry = name + "<" + email +">";
		if (emails.indexOf(entry) < 0) {
			emails.push(entry);
		}
		
	}
	// dump everything into the textarea
	textarea.value = emails.join(emailSep);
	 
	
    if($('thead.contacts').length==0){
    	tableElement.append('<thead class="contacts"><tr><th>Name</th><th>Email</th><th>Cancel</th></tr></thead>');
    }
    // Set up a loop that goes through the items in table one at a time
                    var numberOfListItems = contacts.length;
    				for( var i =  0 ; i < numberOfListItems ; ++i){
                            // add the item text
				            contact=contacts[i];
				            listItem = '<tr><td><input name="name[]" value="'+contact.fullName()+'"/></td><td><input name="email[]" value="'+contact.selectedEmail()+'"/></td><td><button class="deleteRowButton"><i class="fa fa-times"></i></button></td></tr>';
				            data.name[i]=contact.fullName();
				            data.email[i]=contact.selectedEmail();
				            // add listItem to the listElement
				            tableElement.append(listItem);
						}	
	//Bind Delete Row Event					
	$('button.deleteRowButton').click(function () {
	 $(this).parents('tr').first().remove();
	});	
	// dump list
	console.log(emails);
	console.log(data);
	// capture the owner information
	owner_email = (owner && owner.email && owner.email[0] && owner.email[0].address) || "";
	owner_first_name = (owner && owner.first_name) || "";
	owner_last_name = (owner && owner.last_name) || "";
	

}
 
// Replace the domain_key and stylesheet with valid values.
var csPageOptions = {
	domain_key:"{{Config::get('development/cloudsponge.domain_key')}}",
	afterSubmitContacts:populateTextarea,
	selectionLimit:30,
	selectionLimitMessage:'sorry we only allow less than 30 emails to be selected to prevent spammers'
};

//Bind Insert Link
$('a.add_email').click(function(event){
	event.preventDefault();
	if($('thead.contacts').length==0){
    	tableElement.append('<thead class="contacts"><tr><th>Name</th><th>Email</th><th>Cancel</th></tr></thead>');
    }
    var listItem = '<tr><td><input name="name[]"/></td><td><input name="email[]" value=""</td><td><button class="deleteRowButton"><i class="fa fa-times"></i></button></td></tr>';
	tableElement.prepend(listItem);
	//Bind Delete Row Event					
	$('button.deleteRowButton').click(function(event){
		$(this).parents('tr').first().remove();
		event.preventDefault();
	});	
});

$('#contacts').on('click','button.deleteRowButton',function(event){
	$(this).parents('tr').first().remove();
		event.preventDefault();
});

var checkbox = $('a.useThis');
var form=$('#address-request-form');
$('#checkTable').on('click','a.useThis',function(event){
	event.preventDefault;
	$(this).find('i').attr('class','fa fa-check');
	var email=$(this).parent('td').siblings('td.checkEmail').html();
	var address_id=$(this).parent('td').siblings('td:last').attr('data-id');
	console.log(address_id);
	var input=$('input[value="'+email+'"]');
	input.parents('tr').first().remove();
	form.append('<input type="hidden" name="address_id[]" value="'+address_id+'"/>');
});

</script>


<!-- Include the script at the end of the body section -->
<script type="text/javascript" src="//api.cloudsponge.com/address_books.js"></script>
@stop