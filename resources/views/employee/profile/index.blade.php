@extends('layouts.master')
@section('content')

<section class="hr-header mb-5">
<div class="row">
<div class="col-12 col-md-2">
<div class="avatar-wrapper ml-3">
	@if(isset($staff->employee_profile))
	<img class="img-fluid" 
	src="{{asset('/img/'.$staff->employee_profile->img)}}" alt="{{$staff->firstName}}" height="200" width="200">
	@endif
</div>
</div>
<div class="col-12 col-md-3">
	<h2>{{ $staff->firstName }} {{ $staff->lastName }} {{ $staff->cName }}</h2>
	<div>{{ $staff->job->rank }} | {{ $staff->location->name }} </div>
	<div>Joined since {{ $staff->hired->toFormattedDateString() }}   ({{ $staff->hired->diffForHumans() }})</div>
</div>

<div class="hr-contact-list col-md-7">

@if(isset($staff->employee_profile))
<div><i class="fa fa-phone"></i> <span class="text-white">{{ $staff->employee_profile->phone }}</span></div>
@endif
@if(!empty($staff->email))
<div><i class="fa fa-envelope"></i> <a href="mailto:{{ $staff->email }}"><span class="text-white">{{ $staff->email }}</span></a></div>
@endif
</div>

</div>
</section>


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
@if(!empty($staff->employee_profile->sex))
<p>{{ $staff->employee_profile->sex?'Male':'Female' }}</p>
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
													<a href="" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									</div>
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
													<a href="" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
									</div>
								</div>
								<!--end::Portlet-->
{{ csrf_field() }}			
@endsection