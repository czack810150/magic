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
													<a href="javascript:cancelContact({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
												<li class="m-portlet__nav-item">
													<a href="javascript:updateContact({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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
<small>Phone</small>


<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($staff->employee_profile)
{{ $staff->employee_profile->phone }}
@endif" id="phone">
</div>
</div>
</div>

</div>

<div class="form-group m-form__group row">
<div class="col-3">
<div class="info-box pl-3">
<small>Emergency Contact</small>
@if($staff->employee_background)
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$staff->employee_background->emergency_person}}" id="emergency_person">
</div>
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="emergency_person">
@endif

</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Emergency Phone</small>
@if($staff->employee_background)
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$staff->employee_background->emergency_phone}}" id="emergency_phone">
</div>
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="emergency_phone">
@endif

</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Emergency Relation</small>

@if($staff->employee_background)
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="{{$staff->employee_background->emergency_relation}}" id="emergency_relation">
</div>
@else
<input type="text" class="form-control m-input form-control-sm" value="" id="emergency_relation">
@endif

</div>
</div>
</div>



</div>
	</form>
<!--end::Form-->