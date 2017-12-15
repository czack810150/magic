<!--begin::Portlet-->
<div class="m-portlet">
<div id="educationDetails">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Education <small>Details</small>
												</h3>
											</div>
										</div>
										
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:editEducation({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-edit"></i>
													</a>
												</li>
											</ul>
										</div>
										
									</div>
<div class="m-portlet__body">

<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Education</small>
<p>{{ $employee->employee_background->education }} </p>
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>School</small>
@if(!empty($employee->employee_background->school))
<p>{{ $employee->employee_background->school }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Major</small>
@if(!empty($employee->employee_background->major))
<p>{{ $employee->employee_background->major }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Currentlly Enrolled</small>
@if(!empty($employee->employee_background->student))
<p><span class="m--font-success">Yes</span></p>
@else
<p>No</p>
@endif
</div>
</div>


</div> <!-- end of row -->
<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Interests</small>
@if(!empty($employee->employee_background->interest))
<p>{{ $employee->employee_background->interest }}</p>
@else
<p>-</p>
@endif
</div>
</div>
</div> <!-- end of row -->

</div><!-- m-portlet__body -->

</div><!-- end of employment detailes -->																	




<div id="previousWorkDetails">
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
													<a href="javascript:editWorkHistory({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-edit"></i>
													</a>
												</li>
											</ul>
										</div>
										
									</div>
<div class="m-portlet__body">

<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Job title</small>
@if(!empty($employee->employee_background->company_job))
<p>{{ $employee->employee_background->company_job }}</p>
@else
<p>-</p>
@endif
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Organization</small>
@if(!empty($employee->employee_background->company))
<p>{{ $employee->employee_background->company }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Location</small>
@if(!empty($employee->employee_background->company_city))
<p>{{ $employee->employee_background->company_city }}</p>
@else
<p>-</p>
@endif
</div>
</div>

</div> <!-- end of row -->

<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Start</small>
@if(!empty($employee->employee_background->company_start))
<p>{{ $employee->employee_background->company_start }}</p>
@else
<p>-</p>
@endif
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>End</small>
@if(!empty($employee->employee_background->company_end))
<p>{{ $employee->employee_background->company_end }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Reason to quit</small>
@if(!empty($employee->employee_background->company_quit))
<p>{{ $employee->employee_background->company_quit }}</p>
@else
<p>-</p>
@endif
</div>
</div>

</div> <!-- end of row -->

<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Supervisor</small>
@if(!empty($employee->employee_background->company_supervisor))
<p>{{ $employee->employee_background->company_supervisor }}</p>
@else
<p>-</p>
@endif
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Contact</small>
@if(!empty($employee->employee_background->company_contact))
<p>{{ $employee->employee_background->company_contact }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>OK to verify ?</small>
@if(!empty($employee->employee_background->company_check))
<p>Yes</p>
@else
<p>No</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Reason for non-verification</small>
@if(!empty($employee->employee_background->check_reason))
<p>{{ $employee->employee_background->check_reason }}</p>
@else
<p>-</p>
@endif
</div>
</div>

</div> <!-- end of row -->


</div><!-- m-portlet__body -->

</div><!-- end of work history detailes -->																	
</div>
<!--end::Portlet-->