<!--begin::Portlet-->
<div class="m-portlet">
<div id="employmentDetails">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Employment <small>Details</small>
												</h3>
											</div>
										</div>
										@can('update-employment')
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:editEmployment({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-edit"></i>
													</a>
												</li>
											</ul>
										</div>
										@endcan
									</div>
<div class="m-portlet__body">

<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Job Title</small>
<p>{{ $employee->job->rank }} </p>
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Employee ID</small>
@if(!empty($employee->employeeNumber))
<p>{{ $employee->employeeNumber }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Date Hired</small>
@if(!empty($employee->hired))
<p>{{ $employee->hired->toFormattedDateString() }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Termination Date</small>
@if(!empty($employee->termination) )
<p>{{ $employee->termination->toFormattedDateString() }}</p>
@else
<p>-</p>
@endif
</div>
</div>

</div> <!-- end of row -->

@if($employee->user)
<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>User Type</small>
<p>{{ $employee->user->type }} </p>
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Location</small>
<p>{{ $employee->location->name }} </p>
</div>
</div>
</div> <!-- end of row -->
@endif

@if( in_array($user->authorization->type,['accounting','hr','admin','dm']) )
<div class="row">

<div class="col-3">
<div class="info-box pl-3">
<small>SIN</small>

@if($employee->employee_profile->sin)
<p>{{ $employee->employee_profile->sin }} </p>
@else
<p>-</p>
@endif

</div>

</div> <!-- end of row -->
@endif

</div><!-- m-portlet__body -->

</div><!-- end of employment detailes -->																	
</div>
<!--end::Portlet-->