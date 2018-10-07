@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-time-3"></i>
												</span>
												<h3 class="m-portlet__head-text">
													打卡详情
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												
												<li class="m-portlet__nav-item">
{{ Form::select('year',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'periodStart','placeholder'=>'选择薪期']) }}
												</li>
												<li class="m-portlet__nav-item">
														{{ Form::button('View',['class'=>'btn btn-primary','onclick'=>'viewEmployeeClocks()']) }}
												</li>
										
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<main id="clocks">

										</main>
									</div>
								</div>
								<!--end::Portlet-->

<script>
    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

	function viewEmployeeClocks(){
		
			$("#clocks").html(transition);
			$.post(
				'/clocks/employee/year',
				{
					location: $("#location").val(),
					periodStart: $("#periodStart").val(),
					_token: '{{csrf_token()}}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#clocks").html(data);	
					}
				}
				);
		
	}
</script>
@endsection