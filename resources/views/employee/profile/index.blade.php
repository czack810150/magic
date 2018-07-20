@extends('layouts.master')
@section('content')

@if(session('status'))
<div class="row">
<div class="col-12">
	@if(session('statusCode'))
<div class="alert alert-success" role="alert">
{{ session('status') }}
</div>
	@else
	<div class="alert alert-danger" role="alert">
{{ session('status') }}
</div>
	@endif
</div>
</div>
@endif


<section class="hr-header">
<div class="row">
<div class="col-2 col-md-2 mr-3">
<div class="avatar-wrapper ml-3">
	@if(isset($staff->employee_profile))
	<img class="img-fluid" 
	src="{{asset('/storage/'.$staff->employee_profile->img)}}" alt="{{$staff->firstName}}" >
	@can('update-profile-picture',$staff->id)
	<div class="overlay" data-toggle="modal" data-target="#pictureModal">
		<div class="updatePictureText">Update profile picture</div>
	</div>
	@endcan
	@endif
</div>
</div>
<div class="col-7 col-md-5 ml-3">
	<h2>{{ $staff->firstName }} {{ $staff->lastName }} {{ $staff->cName }}  
		@if($staff->status == 'terminated')
		<span class="m--font-danger">Terminated</span> 
		@endif
	</h2>
	<div>{{ $staff->job->rank }} | {{ $staff->location->name }} </div>
	<div>Joined since {{ $staff->hired->toFormattedDateString() }}   ({{ $staff->hired->diffForHumans() }})</div>
</div>

<div class="hr-contact-list col-md-4">

@if(isset($staff->employee_profile))
	@if(!empty($staff->employee_profile->phone))
<div><i class="fa fa-phone"></i> <span class="text-white">{{ $staff->employee_profile->phone }}</span></div>
	@endif
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
    <a class="nav-link" href="javascript:employeeBackground('{{ $staff->id }}')">Background</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:employment('{{ $staff->id }}')">Employment</a>
  </li>
  <li class="nav-item">
  	     <a class="nav-link" href="javascript:employeeStats('{{ $staff->id }}')">Stats</a>
  </li>
  <li class="nav-item">
  	     <a class="nav-link" href="javascript:employeePerformance('{{ $staff->id }}')">Performance</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:employeeTraining('{{ $staff->id }}');">Training & Skills</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:employeeTimeoff({{ $staff->id }})">Time off</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:employeeAccount('{{ $staff->id }}')">Account</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:employeeCompensation('{{ $staff->id }}')">Compensation</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="javascript:employeeAvailability('{{ $staff->id }}')">Availability</a>
  </li>
  @can('note-employee')
  <li class="nav-item">
    <a class="nav-link" href="javascript:employeeNote('{{ $staff->id }}')">Notes</a>
  </li>
  @endcan
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
@if(!empty($staff->employee_profile))
	@if(!is_null($staff->employee_profile->married))
		<p>{{ $staff->employee_profile->married?'Married':'Unmarried' }}</p>
	@else
		<p>-</p>
	@endif
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

<!-- Modal -->
<div class="modal fade" id="pictureModal" tabindex="-1" role="dialog" aria-labelledby="pictureModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
<!--begin::Portlet-->
<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Upload profile picture
				</h3>
			</div>
		</div>
	</div>
	<!--begin::Form-->
	<form class="m-form m-form--fit m-form--label-align-right" method="post" action="/file/employee/{{ $staff->id }}/picture" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="m-portlet__body">
			<div class="form-group m-form__group row">
				
				<div class="col-12">
					<input type="file" name="file">
					<!-- <div class="m-dropzone dropzone"  id="m-dropzone-one">
						<div class="m-dropzone__msg dz-message needsclick">
						    <h3 class="m-dropzone__msg-title">Drop your picture file here or click to upload.</h3>
						    <span class="m-dropzone__msg-desc">jpeg file is supported with max size of 2MB.</span>
						</div>
					</div> -->
				</div>
			</div>
			
			
		</div>
		<div class="m-portlet__foot m-portlet__foot--fit">
			<div class="m-form__actions m-form__actions">
				<div class="row">
					<div class="col-lg-9 ml-lg-auto">
						<button type="submit" class="btn btn-brand">Submit</button>
						<button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!--end::Form-->
</div>
<!--end::Portlet-->
  
      
    </div>
  </div>
</div>

{{ csrf_field() }}			
@endsection


