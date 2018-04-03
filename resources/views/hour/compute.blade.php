@extends('layouts.master')
@section('content')
@include('hour.nav')

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
							Compute Employee Hours 	
						</h3>
					</div>
				</div>
			</div>
			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right">
				<div class="m-portlet__body">
					<div class="form-group m-form__group m--margin-top-10"  id="hours">
						<div class="alert m-alert m-alert--default" role="alert">
							A place to compute employee scheduled hours, clocked hours, effective hours, overtime hours and night shift hours for a given payroll period.
						</div>
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
						{{ Form::button('Compute',['class'=>'btn btn-danger','onclick'=>'computeHours()','id'=>'computeBtn']) }}
						
					</div>
				</div>
			</form>
			<!--end::Form-->			
		</div>
		<!--end::Portlet-->
	</div>
</div>


<script>
    let transition = '<div class="row justify-content-md-center"><div class="col-md-1"><h1><i class="fa fa-spinner fa-pulse fa"></i></h1></div></div>';

	function computeHours(){
		var forDate = $("#dateRange").val();
		var forLocation = $('#forLocation').val();
		if( $("#dateRange").val() == ''){
			alert('You must choose a date range.');
		} else{
			$("#hours").html(transition);
			$("#computeBtn").prop('disabled',true);
			
			$.post(
				'/hours/computeEngine',
				{
					startDate: forDate,
					location: forLocation,
					_token: '{{ csrf_token() }}',
				},
				function(data,status){                    
					if(status == 'success'){
						var html = '<p class="alert alert-success"><strong>计算成功！</strong> ' + data + ' new records have been saved.</p>';
						$("#hours").html(html);
						$("#computeBtn").prop('disabled',false);
					}
				}
				);
		}
		
	}
	
</script>

@endsection