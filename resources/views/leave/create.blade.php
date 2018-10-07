@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--mobile col-sm-12 col-md-10 col-lg-6">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Request Leave
				</h3>
			</div>
		</div>
	
	</div>
	<!--begin::Form-->
			<form class="m-form" method="POST" action="{{url('request/leave/send')}}">
				{{csrf_field()}}
				<div class="m-portlet__body" >

					<div class="m-form__section m-form__section--first">
						
							
							@if(isset($employees))
							<div class="form-group m-form__group">
							<label for="example_input_full_name">Employee</label>
{{ Form::select('employee',$employees,Auth::user()->authorization->employee_id,['class'=>'custom-select m-input']) }}
	</div>
@else
<input name="employee" type="text" value="{{Auth::user()->authorization->employee_id}}" hidden>
@endif
<input name="from" id="from" type="text" value="" hidden>
<input name="to" id="to" type="text" value="" hidden>


					
						<div class="form-group m-form__group">
							<label>Leave Type</label>
{{ Form::select('leaveType',$types,null,['class'=>'custom-select m-input']) }}
							<span class="m-form__help">We'll never share your email with anyone else</span>
						</div>			
						<div class="form-group m-form__group">
							<label>Date Range</label>
							
								
								<input type="text" name="daterange" id="daterange" class="form-control m-input" placeholder="Pick dates">
						
						</div>			
						<div class="m-form__group form-group">
							<label for="">Comments</label>
							<textarea class="form-control m-input" rows="3" name="comment"></textarea>
		                </div>
		            </div>

	            </div>
	            <div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-secondary">Cancel</button>
					</div>
				</div>
			</form>
			<!--end::Form-->
</div>		        

@endsection
@section('pageJS')
<script>
	 $('input[name="daterange"]').daterangepicker({
	});
	 var drp = $('input[name="daterange"]').data('daterangepicker');
	$('#from').val(drp.startDate.format('YYYY-MM-DD'));
   			$('#to').val(drp.endDate.format('YYYY-MM-DD'));
	$('#daterange').on('apply.daterangepicker', function(ev, picker) {
  			$('#from').val(picker.startDate.format('YYYY-MM-DD'));
   			$('#to').val(picker.endDate.format('YYYY-MM-DD'));

});
</script>
@endsection