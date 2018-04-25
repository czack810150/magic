@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-calendar"></i>
												</span>
												<h3 class="m-portlet__head-text">
													历史排班
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												
												<li class="m-portlet__nav-item">
{{ Form::select('year',$dates,$currentYear,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'year']) }}
												</li>
												<li class="m-portlet__nav-item" id="periods">
{{ Form::select('period',$periods,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'period']) }}
												</li>
												<li class="m-portlet__nav-item">
														{{ Form::button('View',['class'=>'btn btn-primary','onclick'=>'viewScheduleHistory()']) }}
												</li>
										
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<main id="schedule">
<div class="m-alert m-alert--icon m-alert--outline alert alert-info alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="la la-history"></i>
					</div>
					<div class="m-alert__text">
             			<strong>View your past scheduled shifts</strong> 在此可以调看自己的历史排班记录。	
					</div>	
					</div>
										</main>
									</div>
								</div>
								<!--end::Portlet-->

<script>


	function viewScheduleHistory(){
		
			$.post(
				'/shifts/history',
				{
					
					period: $("#period").val(),
					_token: '{{csrf_token()}}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#schedule").html(data);	
					}
				}
				);
		
	}

	var year = document.getElementById('year');
	year.addEventListener('change',function(){

			$.post(
				'/periodsByYear',
				{
					year: $("#year").val(),
					_token: '{{csrf_token()}}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#periods").html(data);	
					}
				}
				);
	},false);
</script>
@endsection