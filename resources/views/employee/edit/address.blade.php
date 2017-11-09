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
													<a href="javascript:cancelAddress({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
												<li class="m-portlet__nav-item">
													<a href="javascript:updateAddress({{ $staff->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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
<small>Address</small>


<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($staff->employee_profile)
{{ $staff->employee_profile->address }}
@endif" id="address">
</div>
</div>
</div>



<div class="col-md-3">
<div class="info-box pl-3">
<small>City</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($staff->employee_profile)
{{ $staff->employee_profile->city }}
@endif" id="city">
</div>
</div>

</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>State/Province</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($staff->employee_profile)
{{ $staff->employee_profile->state }}
@endif" id="state">
</div>
</div>

</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>Postal Code</small>

<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($staff->employee_profile)
{{ $staff->employee_profile->state }}
@endif" id="zip">
</div>
</div>
</div>

</div>



</div>
	</form>
<!--end::Form-->