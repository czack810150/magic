<!--begin::Portlet-->
<div class="m-portlet">
<div id="employeeNotes">
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
													<a href="javascript:editEmployeeAccount({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-edit"></i>
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
@if($authorization)
<p>{{ $authorization->user->email }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Password</small>
@if($authorization)
<p>******</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Type</small>
@if($authorization)
<p>{{ $authorization->type }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Last Login</small>
@if($authorization)
<p>{{ $authorization->user->last_login }}</p>
@else
<p>-</p>
@endif
</div>
</div>


</div>




</div>
	</form>
									<!--end::Form-->

</div><!-- end of employeeNotes -->																	
</div>
<!--end::Portlet-->
