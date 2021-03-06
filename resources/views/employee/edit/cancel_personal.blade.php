									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Personal <small>Details</small>
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:editPersonal({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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
<small>Name</small>
<p>{{ $staff->firstName }} {{ $staff->lastName }} {{ $staff->cName }}</p>
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Nickname</small>
@if(!empty($staff->employee_profile->alias))
<p>{{ $staff->employee_profile->alias }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Email</small>
@if(!empty($staff->email))
<p>{{ $staff->email }}</p>
@else
<p>-</p>
@endif
</div>
</div>



<div class="col-3">
<div class="info-box pl-3">
<small>Gender</small>
@if(!empty($staff->employee_profile->sex))
<p>{{ $staff->employee_profile->sex }}</p>
@else
<p>-</p>
@endif
</div>
</div>
</div>

<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Birthdate</small>
@if(!empty($staff->employee_profile->dob))
<p>{{ $staff->employee_profile->dob }}</p>
@else
<p>-</p>
@endif

</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Home town</small>
@if(!empty($staff->employee_background->hometown))
<p>{{ $staff->employee_background->hometown }}</p>
@else
<p>-</p>
@endif
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Immigration Status</small>
@if(!empty($staff->employee_background->canada_status))
<p>{{ $staff->employee_background->canada_status }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Status Expiry</small>
@if(!empty($staff->employee_background->status_expiry))
<p>{{ $staff->employee_background->status_expiry }}</p>
@else
<p>-</p>
@endif
</div>
</div>

</div>
<div class="row">
	<div class="col-3">
<div class="info-box pl-3">
<small>Marital Status</small>
@if(!is_null($staff->employee_profile->married))
<p>{{ $staff->employee_profile->married?'Married':'Unmarried' }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Language</small>
<p>
@if(!empty($staff->employee_background))
	@if($staff->employee_background->english)
		<span>English</span>
	@endif
	@if($staff->employee_background->chinese)
		<span>国语</span>
	@endif
	@if($staff->employee_background->cantonese)
		<span>Cantonese</span>
	@endif
	@if($staff->employee_background->french)
		<span>French</span>
	@endif
@else
-
@endif
</p>
</div>
</div>

</div>


</div>