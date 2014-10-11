<div style="margin-top:50px;">
	<div>
		<h1>Download Prints</h1>
		<h3>Choose date</h3>
			<form class="form-inline" action="{{URL::action('AdminController@download')}}" method="post">
				<div class="inline">
					<h3>the number of seconds since January 1 1970 00:00:00 UTC</h3>
	                <div class='input-group date'>
                       <p>Start: <input class="control-group datepicker" type="text" name="start"></p>
	                </div>
	                <div class='input-group date' id='datetimepicker2'>
                       <p>End: <input class="control-group datepicker" type="text" name="end"></p>
	                </div>
	                <div class="input-group">
	                	<button>Download</button>
	                </div>
                </div>
           </form>
	</div>
</div>
