<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Contact <small>Details</small>
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:editContact({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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
<small>Phone</small>
@if($staff->employee_profile)
<p>{{ $staff->employee_profile->phone }}</p>
@else
<p>-</p>
@endif
</div>
</div>
</div>

<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Emergency Contact</small>
@if(!is_null($staff->employee_background))
<p>{{ $staff->employee_background->emergency_person }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Emergency Phone</small>
@if(!is_null($staff->employee_background))
<p>{{ $staff->employee_background->emergency_phone }}</p>
@else
<p>-</p>
@endif
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Emergency Relation</small>
@if(!is_null($staff->employee_background))
<p>{{ $staff->employee_background->emergency_relation }}</p>
@else
<p>-</p>
@endif
</div>
</div>
</div>



</div>