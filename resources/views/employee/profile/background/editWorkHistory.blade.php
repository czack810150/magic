<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Work History <small>Details</small>
												</h3>
											</div>
										</div>
										
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:employeeBackground({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
												<li class="m-portlet__nav-item">
													<a href="javascript:updateWorkHistory({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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



<div class="col-md-3">
<div class="info-box pl-3">
<small>Job title</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->company_job )
{{ $employee->employee_background->company_job }}
@endif" id="job" name="job">
</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>Organization</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->company )
{{ $employee->employee_background->company }}
@endif" id="company" name="company">
</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>Location</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->company_city )
{{ $employee->employee_background->company_city }}
@endif" id="location" name="location">
</div>
</div>
</div>

</div> <!-- end of row -->

<div class="form-group m-form__group row">

<div class="col-md-3">
<div class="info-box pl-3">
<small>Start</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->company_start )
{{ $employee->employee_background->company_start }}
@endif" id="start" name="start">
</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>End</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->company_end )
{{ $employee->employee_background->company_end }}
@endif" id="end" name="end">
</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>Reason to quit</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->company_quit )
{{ $employee->employee_background->company_quit }}
@endif" id="quit_reason" name="quit_reason">
</div>
</div>
</div>

</div> <!-- end of row -->

<div class="form-group m-form__group row">

<div class="col-md-3">
<div class="info-box pl-3">
<small>Supervisor</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->company_supervisor )
{{ $employee->employee_background->company_supervisor }}
@endif" id="supervisor" name="supervisor">
</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>Contact</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->company_contact )
{{ $employee->employee_background->company_contact }}
@endif" id="contact" name="contact">
</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>OK to verify?</small>
<div class=" m-checkbox-list">
<label class="m-checkbox">
<input type="checkbox" class="form-control m-input form-control-sm" 
@if($employee->employee_background->company_check )
checked
@endif
 id="check" name="check">
 <span></span>
</label>
</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>Reason for non-verification</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->check_reason )
{{ $employee->employee_background->check_reason }}
@endif" id="check_reason" name="check_reason">
</div>
</div>
</div>

</div> <!-- end of row -->


</div><!-- m-portlet__body -->
</form>
<!--end::Form-->
<script>
	$('#start').datepicker({
			format:'yyyy-mm-dd',
			@if(!empty($staff->employee_background->company_start))
			defaultViewDate: '{{ $staff->employee_background->company_start }}'
			@endif
	}
		);
	$('#end').datepicker({
			format:'yyyy-mm-dd',
			@if(!empty($staff->employee_background->company_end))
			defaultViewDate: '{{ $staff->employee_background->company_end }}'
			@endif
	}
		);
</script>