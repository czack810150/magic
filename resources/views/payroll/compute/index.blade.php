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
			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right" method="POST" action="/payroll/compute">
				<div class="m-portlet__body">
					<div class="form-group m-form__group m--margin-top-10"  id="payroll">
						<div class="alert m-alert m-alert--default" role="alert">
							A place to compute employee payroll based on effective hours, overtime hours and night shift hours for a given payroll period.
						</div>
						{{ $yearOptions }}
					</div>
					<div class="form-group m-form__group"  id="errors">
					@if ($errors->any())
   					<div class="m-alert m-alert--icon m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="la la-warning"></i>
					</div>
					<div class="m-alert__text">
             			<strong>{{ $errors->first() }}</strong> Please choose a payroll.
					</div>	
					</div>
					@endif
					</div>
					
					
				
					<div class="form-group m-form__group row">
						<div class="col-3">
						{{ Form::label('dateRange','Payroll period',[])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select form-control','placeholder'=>'Choose date range']) }}
						<span class="m-form__help">Please provide the payroll period</span>
						</div>

						<div class="col-3">
						{{ Form::label('forLocation','Location',[])}}
			{{ Form::select('forLocation',$locations,'all',['class'=>'custom-select form-control','placeholder'=>'Choose location']) }}
						<span class="m-form__help">Choose one or all locations</span>
						</div>
					</div>
				
					
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions">
						{{ Form::submit('Compute',['class'=>'btn btn-primary']) }}
		{{csrf_field()}}
						
					</div>
				</div>
			</form>
			<!--end::Form-->			
		</div>
		<!--end::Portlet-->
	</div>
</div>

@endsection