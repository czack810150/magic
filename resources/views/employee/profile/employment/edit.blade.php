									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Employment <small>Details</small>
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:employment({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
												<li class="m-portlet__nav-item">
													<a href="javascript:updateEmployment({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-check"></i>
													</a>
												</li>
											</ul>
										</div>
									</div>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right">
<div class="m-portlet__body">

<div class="form-group m-form__group row">
<div class="col-3">
<div class="info-box pl-3">
<small>Job Title</small>
<div class="input-group m-input-group m-input-group--square">
{{ Form::select('job',$jobs,$employee->job_id,['class'=>'form-control m-input form-control-sm'])}}
</div>
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Employee ID</small>
@if(!empty($employee->employeeNumber))
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$employee->employeeNumber}}" name="employeeNumber">
</div>
@else
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="" name="employeeNumber">
</div>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Date Hired</small>
@if(!empty($employee->hired))
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$employee->hired->toDateString()}}" id="hired" name="hired">
</div>
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="hired" name="hired">
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Termination Date</small>
@if(!empty($employee->termination))
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$employee->termination->toDateString()}}" id="termination" name="termination">
</div>
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="termination" name="termination">
@endif
</div>
</div>


</div> <!-- end of row -->

<div class="form-group m-form__group row">
@if($employee->user)

<div class="col-3">
<div class="info-box pl-3">
<small>User Type</small>
<div class="input-group m-input-group m-input-group--square">
{{ Form::select('type',$types,$employee->user->type,['class'=>'form-control m-input form-control-sm'])}}
</div>
</div>
</div>
@endif


<div class="col-3">
<div class="info-box pl-3">
<small>Location</small>
<div class="input-group m-input-group m-input-group--square">
{{ Form::select('location',$locations,$employee->location_id,['class'=>'form-control m-input form-control-sm'])}}
</div>
</div>
</div>


</div> <!-- end of row -->




@if( in_array($user->authorization->type,['accounting','hr','admin']) )
<div class="form-group m-form__group row">

<div class="col-3">
<div class="info-box pl-3">
<small>SIN</small>

<div class="input-group m-input-group m-input-group--square">
@if($employee->employee_profile->sin)
<input type="text" class="form-control m-input form-control-sm" value="{{$employee->employee_profile->sin}}" id="sin" name="sin">
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="sin" name="sin">
@endif
</div>

</div>
</div>
</div> <!-- end of row -->
@endif

</div><!-- m-portlet__body -->
</form>

<script>
	$('#hired').datepicker({
			format:'yyyy-mm-dd',
			@if(!empty($employee->hired))
			defaultViewDate: '{{ $employee->hired->toDateString() }}'
			@endif
	}
		);
	$('#termination').datepicker({
			format:'yyyy-mm-dd',
			@if(!empty($employee->termination))
			defaultViewDate: '{{ $employee->termination->toDateString() }}'
			@endif
	}
		);
</script>