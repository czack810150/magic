<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Education <small>Details</small>
												</h3>
											</div>
										</div>
										
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:employeeBackground({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
												<li class="m-portlet__nav-item">
													<a href="javascript:updateEducation({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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
<small>Education</small>

<div class="input-group m-input-group m-input-group--square">
{{ Form::select('education',$educations,$employee->employee_background->education,['id' => 'education','class'=>'form-control m-input form-control-sm']) }}

</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>School</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->school )
{{ $employee->employee_background->school }}
@endif" id="school" name="school">
</div>
</div>
</div>

<div class="col-md-3">
<div class="info-box pl-3">
<small>Major</small>
<div class="input-group m-input-group m-input-group--square">
<input type="text" class="form-control m-input form-control-sm" value="
@if($employee->employee_background->major )
{{ $employee->employee_background->major }}
@endif" id="major" name="major">
</div>
</div>
</div>

</div> <!-- end of row -->





</div><!-- m-portlet__body -->
</form>
<!--end::Form-->