@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-coins"></i>
												</span>
												<h3 class="m-portlet__head-text">
													Payroll Details
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location'])}}											
												</li>
												
												<li class="m-portlet__nav-item">
{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range','id'=>'dateRange']) }}
												</li>
												<li class="m-portlet__nav-item">
												
														{{ Form::button('View',['class'=>'btn btn-primary','onclick'=>'viewLocationData()']) }}
												
												</li>
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<main id="payroll"></main>
									</div>
								</div>
								<!--end::Portlet-->

<script>
    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

	function viewLocationData(){
		if($("#location").val() == '' || $("#dateRange").val()== ''){
			alert('You must choose a location and a date range.');
		} else{
			$("#payroll").html(transition);
			$.post(
				'/payroll/fetch',
				{
					location: $("#location").val(),
					startDate: $("#dateRange").val(),
					_token: '{{csrf_token()}}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#payroll").html(data);	
					}
				}
				);
		}
		
	}
</script>
@endsection