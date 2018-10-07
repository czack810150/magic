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
													<a href="javascript:cancelPersonal({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
												<li class="m-portlet__nav-item">
													<a href="javascript:updatePersonal({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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

<div class="col-md-2">
<div class="info-box pl-3">
<small>First</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if(!empty($staff->firstName))
{{$staff->firstName}}
@endif" id="firstName">
</div>
</div>
</div>

<div class="col-md-2">
<div class="info-box pl-3">
<small>Last</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if(!empty($staff->lastName))
{{$staff->lastName}}
@endif" id="lastName">
</div>
</div>
</div>
<div class="col-md-2">
<div class="info-box pl-3">
<small>中文</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if(!empty($staff->cName))
{{$staff->cName}}
@endif" id="cName">
</div>
</div>
</div>

<div class="col-md-2">
<div class="info-box pl-3">
<small>Nickname</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if(!empty($staff->employee_profile->alias))
{{$staff->employee_profile->alias}}
@endif" id="alias">
</div>
</div>
</div>

<div class="col-md-2">
<div class="info-box pl-3">
<small>Email</small>
<div class="input-group m-input-group m-input-group--square">
<input type="email" class="form-control m-input form-control-sm" value="
@if(!empty($staff->email))
{{$staff->email}}
@endif" id="email">
</div>
</div>
</div>
<div class="col-md-2">
<div class="info-box pl-3">
<small>Gender</small>
@if(!empty($staff->employee_profile->sex))
{{ Form::select('gender',['female'=>'Female','male'=>'Male','non-binary'=>'Non-binary'],$staff->employee_profile->sex,['id'=>'gender',
'class'=>'form-control m-input form-control-sm']) }}
@else
{{ Form::select('gender',['female'=>'Female','male'=>'Male','non-binary'=>'Non-binary'],null,['id'=>'gender','placeholder'=>'Choose a gender',
'class'=>'form-control m-input form-control-sm']) }}
@endif
</div>
</div>
</div>

<div class="form-group m-form__group row">
<div class="col-3">
<div class="info-box pl-3">
<small>Birthdate</small>
@if(!empty($staff->employee_profile->dob))
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$staff->employee_profile->dob}}" id="dob">
</div>
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="dob">
@endif

</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Home town</small>
@if($staff->employee_background)
	@if(!empty($staff->employee_background->hometown))
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$staff->employee_background->hometown}}" id="hometown">
</div>
	@else
	<input type="text" class="form-control m-input form-control-sm" value="" id="hometown">
	@endif
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="hometown">
@endif
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Immigration Status</small>
@if($staff->employee_background)
	@if(!empty($staff->employee_background->canada_status))
{{ Form::select('canada_status',
[
'unknown' => 'Unknown',
'visitor' => 'Visitor',
'study permit' => 'Study Permit',
'work permit' => 'Work Permit',
'pr' => 'Permanent Resident',
'citizen' => 'Canadian Citizen'
],$staff->employee_background->canada_status,['id'=>'canada_status',
'class'=>'form-control m-input form-control-sm']) }}

	@endif
@else
{{ Form::select('canada_status',[
'unknown' => 'Unknown',
'visitor' => 'Visitor',
'study_permit' => 'Study Permit',
'work_permit' => 'Work Permit',
'pr' => 'Permanent Resident',
'citizen' => 'Canadian Citizen'
],null,['id'=>'canada_status','placeholder'=>'Immigration status',
'class'=>'form-control m-input form-control-sm']) }}
@endif
</div>
</div>


<div class="col-3">
<div class="info-box pl-3">
<small>Status Expiry</small>

@if($staff->employee_background)
	@if(!empty($staff->employee_background->status_expiry))
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$staff->employee_background->status_expiry}}" id="status_expiry">
</div>
	@else
<input type="text" class="form-control m-input form-control-sm" value="" id="status_expiry">
	@endif
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="status_expiry">
@endif

</div>
</div>



</div>
<div class="form-group m-form__group row">
	<div class="col-3">
<div class="info-box pl-3">
<small>Marital Status</small>

@if(isset($staff->employee_profile->married))
{{ Form::select('married',['0'=>'Unmarried','1'=>'Married'],$staff->employee_profile->married,['id'=>'married',
'class'=>'form-control m-input form-control-sm']) }}
@else
{{ Form::select('married',['0'=>'Unmarried','1'=>'Married'],null,['id'=>'married','placeholder'=>'Marital Status',
'class'=>'form-control m-input form-control-sm']) }}
@endif
</div>
</div>

<div class="col-9">
<div class="info-box pl-3">
<small>Language</small>
@if($staff->employee_background)
<div class="m-checkbox-inline">
	<label class="m-checkbox"><input type="checkbox" id="english" {{ $staff->employee_background->english?'checked':'' }}>English<span></span></label>

	<label class="m-checkbox"><input type="checkbox" id="chinese" {{ $staff->employee_background->chinese?'checked':'' }}>国语<span></span></label>

	<label class="m-checkbox"><input type="checkbox" id="cantonese" {{ $staff->employee_background->cantonese?'checked':'' }}>Cantonese<span></span></label>
	<label class="m-checkbox"><input type="checkbox" id="french" {{ $staff->employee_background->french?'checked':'' }}>French<span></span></label>
</div>
@else
<div class="m-checkbox-inline">
	<label class="m-checkbox"><input type="checkbox" id="english" >English<span></span></label>

	<label class="m-checkbox"><input type="checkbox" id="chinese" >国语<span></span></label>

	<label class="m-checkbox"><input type="checkbox" id="cantonese" >Cantonese<span></span></label>
	<label class="m-checkbox"><input type="checkbox" id="french" >French<span></span></label>
</div>
@endif

</div>
</div>

</div>


</div>
	</form>
									<!--end::Form-->
<script>
	$('#dob').datepicker({
			format:'yyyy-mm-dd',
			@if(!empty($staff->employee_profile->dob))
			defaultViewDate: '{{ $staff->employee_profile->dob }}'
			@endif
	}
		);
	$('#status_expiry').datepicker({
			format:'yyyy-mm-dd',
			@if(!empty($staff->employee_background->status_expiry))
			defaultViewDate: '{{ $staff->employee_background->status_expiry }}'
			@endif
	}
		);
</script>