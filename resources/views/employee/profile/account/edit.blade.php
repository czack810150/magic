<!--begin::Portlet-->
<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												
												<h3 class="m-portlet__head-text">
													Account <small>Details</small>
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													<a href="javascript:employeeAccount({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-close"></i>
													</a>
												</li>
												<li class="m-portlet__nav-item">
													<a href="javascript:updateEmployeeAccount({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
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

<div class="col-3">
<div class="info-box pl-3">
<small>Username</small>
<div class="input-group m-input-group m-input-group--square">
{{ Form::text('username',$authorization?$authorization->user->email:null,['class'=>'form-control m-input form-control-sm'])}}
</div>
</div>
</div>


<div class="col-3">
<div class="info-box pl-3">
<small>Password</small>
<div class="input-group m-input-group m-input-group--square">
{{ Form::text('password',null,['class'=>'form-control m-input form-control-sm','placeholder'=>'password'])}}
</div>
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Password Confirmation</small>
<div class="input-group m-input-group m-input-group--square">
{{ Form::text('password_confirmation',null,['class'=>'form-control m-input form-control-sm','placeholder'=>'confirm password'])}}
</div>
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Type</small>
<div class="input-group m-input-group m-input-group--square">
Employee
</div>
</div>
</div>





</div> <!-- end of row -->





</div><!-- m-portlet__body -->
</form>

</div>
<!--end::Portlet-->