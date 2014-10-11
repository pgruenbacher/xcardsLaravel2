jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			//jQuery("#formID").validationEngine();
			//Prepare jTable
			$('#AddressTableContainer').jtable({
				title: 'Address Book',
			  	actions: {
					listAction: '{{URL:route('Address-action-list')}}'
					}
				},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					addressee: {
						title: 'Full Name',
						width: '25%',
					},
					email: {
						title: 'email',
						width: '20%',
					},
					delivery_line_1: {
						title: 'Address line 1',
						width: '20%'
					},
					last_line: {
						title: 'Address line 2',
						width: '35%'
					}
					
				},
				
				});
	
				//Load address list from server
				$('#AddressTableContainer').jtable('load');
});