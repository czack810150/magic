@extends('layouts.master')
@section('content')

<section class="hr-header">
<div class="row">
<div class="col-12 col-md-2">
<div class="avatar-wrapper ml-3">
	@if(isset($staff->employee_profile))
	<img class="img-fluid" 
	src="{{asset('/img/'.$staff->employee_profile->img)}}" alt="{{$staff->firstName}}" height="200" width="200">
	@endif
</div>
</div>
<div class="col-12 col-md-6">
	<h2>{{ $staff->firstName }} {{ $staff->lastName }} {{ $staff->cName }}</h2>
	<div>{{ $staff->job->rank }} | {{ $staff->location->name }} </div>
	<div>Joined since {{ $staff->hired->toFormattedDateString() }}   ({{ $staff->hired->diffForHumans() }})</div>
</div>

<div class="hr-contact-list col-md-4">

@if(isset($staff->employee_profile))
<div><i class="fa fa-phone"></i> <span class="text-white">{{ $staff->employee_profile->phone }}</span></div>
@endif
@if(!empty($staff->email))
<div><i class="fa fa-envelope"></i> <a href="mailto:{{ $staff->email }}"><span class="text-white">{{ $staff->email }}</span></a></div>
@endif
</div>


<nav class="profile-category mx-auto">
<div class="row">
<div class="col-md-12">
<ul class="nav justify-content-center">
  <li class="nav-item">
    <a class="nav-link" href="/staff/profile/{{ $staff->id }}/show">Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:employment('{{ $staff->id }}')">Employment</a>
  <li class="nav-item">
  	 <li class="nav-item">
    <a class="nav-link" href="javascript:employeePerformance('{{ $staff->id }}')">Performance</a>
  <li class="nav-item">
    <a class="nav-link" href="#">Training</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Time off</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Account</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Compensation</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:employeeNote('{{ $staff->id }}')">Notes</a>
  </li>
</ul>
</div>
</div>
</nav>
</div>


</section>

<main id="employee">
<!--begin::Portlet-->
<div class="m-portlet">
<div id="personalDetails">
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
@if(!is_null($staff->employee_profile))
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
<small>Status</small>
@if(!empty($staff->employee_background->canada_status))
<p>{{ $staff->employee_background->canada_status }}</p>
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
@if(!empty($staff->employee_profile->married))
<p>{{ $staff->employee_profile->married?'Married':'Unmarried' }}</p>
@else
<p>-</p>
@endif
</div>
</div>
</div>


</div>
</div><!-- end of personal detailes -->									
<!-- begin of contact details -->
<div id="contactDetails">
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
@if( $staff->employee_background )
<p>{{ $staff->employee_background->emergency_person }}</p>
@else
<p>-</p>
@endif

</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Emergency Phone</small>
@if( $staff->employee_background )
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
</div><!-- end of contact detailes -->									
<!-- begin of address details -->
<div id="addressDetails">
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
@if(isset($staff->employee_profile->address))
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
</div><!-- end of adress detailes -->	



								</div>
								<!--end::Portlet-->
</main>
{{ csrf_field() }}			
@endsection