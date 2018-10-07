@extends('layouts.master')
@section('content')

 <div class="row">
	<div class="col-12">
		<!--begin::Portlet-->
		<div class="m-portlet m-portlet--tab">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Compute Employee Payroll 	
						</h3>
					</div>
				</div>
			</div>
	
			
				<div class="m-portlet__body">
					<div class="form-group m-form__group m--margin-top-10"  id="payroll">
						<div class="alert m-alert m-alert--default" role="alert">
							A place to compute employee payroll based on effective hours, overtime hours and night shift hours for a given payroll period.
						</div>
					</div>

					<div class="m-alert m-alert--icon m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="la la-check-circle"></i>
					</div>
					<div class="m-alert__text">
             			<strong>{{ $message }}</strong>	payroll records have been saved!
					</div>	
					</div>


				</div>
			
				
					
					
				
					
				
		</div>
		<!--end::Portlet-->
	</div>
</div>

@endsection