									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Address <small>Details</small>
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:editAddress({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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
<small>Address</small>
@if( isset($staff->employee_profile->address) )
<p>{{ $staff->employee_profile->address }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>City</small>
@if( isset($staff->employee_profile->city) )
<p>{{ $staff->employee_profile->city }}</p>
@else
<p>-</p>
@endif

</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>State/Province</small>
@if( isset($staff->employee_profile->state) )
<p>{{ $staff->employee_profile->state }}</p>
@else
<p>-</p>
@endif
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Postal Code</small>
@if( isset($staff->employee_profile->zip) )
<p>{{ $staff->employee_profile->zip }}</p>
@else
<p>-</p>
@endif
</div>
</div>

</div>



</div>