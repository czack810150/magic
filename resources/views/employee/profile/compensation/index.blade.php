<!--begin::Portlet-->
<div class="m-portlet">
<div id="employeeNotes">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Salary <small>Details</small>
												</h3>
											</div>
										</div>
										
									</div>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right">
<div class="m-portlet__body">
									
<div class="form-group m-form__group row">

<div class="col-md-2">
<div class="info-box pl-3">
<small>Basic Rate</small>
<p>${{ number_format($basicRate->minimumPay/100,2,'.',',') }} / Hour</p>
</div>
</div>

<div class="col-md-2">
<div class="info-box pl-3">
<small>Position Rate</small>
<p>${{ number_format($employee->job->rate/100,2,'.',',') }} / Hour</p>
</div>
</div>

<div class="col-md-2">
<div class="info-box pl-3">
<small>Tip Rate</small>
@if($employee->job->tip)
<p>{{ $employee->job->tip*100 }}%</p>
@else
<p>Receives no tips</p>
@endif
</div>
</div>

<div class="col-md-2">
<div class="info-box pl-3">
<small>Meal Rate</small>
<p>${{ number_format($basicRate->mealRate,2,'.',',') }} / Hour</p>
</div>
</div>

<div class="col-md-2">
<div class="info-box pl-3">
<small>Night Rate</small>
<p>${{ number_format($basicRate->nightRate,2,'.',',') }} / Hour</p>
</div>
</div>

</div>




</div>
	</form>
									<!--end::Form-->

</div><!-- end of employeeNotes -->																	
</div>
<!--end::Portlet-->
