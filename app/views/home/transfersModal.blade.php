<!-- Button trigger modal -->
<button id="transferToggle" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  You've received credits!
</button>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span style="color:#2C3E50;" aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pending Credits</h4>
      </div>
      <div class="modal-body">
      	<p>The following credits have been shared with you.</p>
      	<p>Click confirm if you wish to accept the credits.</p>
      	<form id="transferForm" action="{{URL::action('HomeController@confirmExchange')}}" method="post">
      		<table class="table table-condensed">
      			<thead>
      				<tr>
      					<th>From</th>
      					<th>Amount</th>
      					<th>Date</th>
      				</tr>
      			</thead>
      			<tbody>
      				 @foreach($transfers as $transfer)
			        <input type="hidden" name="transfers[]" value="{{$transfer->id}}">
			        <tr>
			        	<td>{{$transfer->giver()->first()->first}}</td>
			        	<td>{{$transfer->credits}}</td>
			        	<td>{{$transfer->created_at}}</td>
			        </tr>
			        @endforeach
      			</tbody>
      		</table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="denyTransfer" class="btn btn-default" >Deny</button>
        <button type="button" id="confirmTransfer" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>
<script src="{{URL::asset('js/jquery.form.min.js')}}"></script>
<script>
	$(document).ready(function(){
		var creditSpan = $('span.credits');
		
		//show the modal on load
		$('#myModal').modal({
			show: true
		})
		//Confirm
		$('#confirmTransfer').on('click',function(){
			console.log('confirm');
			$('#transferForm').ajaxSubmit({
				data: { accept: true },
				success:function() { 
					        console.log('ajaxconfirm');
					        updateCredits();
					    } 
		  	}); 
			hideModal();
		});
		//Deny
		$('#denyTransfer').on('click',function(){
			console.log('deny');
			if(confirm('Are you sure? It\'s free credits!')){
				hideModal();
				$('#transferForm').ajaxSubmit({
				data: { accept: false },
				success:function(data) { 
							console.log(data);
					        alert('Denied!'); 
					    } 
				}); 
			}
			
		});
		//Close
		function hideModal(){
			$('#myModal').modal('hide');
			
			$('#transferToggle').hide();
		}
		
	    function updateCredits(){
	    	console.log('updatecredits');
			$.ajax({
				url:'{{URL::to('updateCredits')}}',
				type:'POST',
				success:function(data){
					data=JSON.parse(data)||$.parseJSON(data);
					var credits=data.credits;
					creditSpan.each(function(index,element){
						$(this).html(credits);
					});
				}
			});
		}
		
	});
</script>