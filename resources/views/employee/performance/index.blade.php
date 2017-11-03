@extends('layouts.master')
@section('content')


<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-users"></i>
												</span>
												<h3 class="m-portlet__head-text">
													Employee Scores
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
													
														{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0',
'placeholder' => 'Choose a location','id'=>'location','onchange'=>'locationEmployees()'
])}}
											
												</li>
												
												<li class="m-portlet__nav-item">
												
														{{ Form::select('period',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'period','onchange'=>'locationEmployees()'
])}}
												</li>
												<li class="m-portlet__nav-item">
													<a href="javascript:locationEmployees()" class="m-portlet__nav-link m-portlet__nav-link--icon">
														<i class="la la-refresh"></i>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<main id="employees"></main>
									</div>
								</div>
								<!--end::Portlet-->


@endsection
@section('pageJS')
<script>
//var list = $('#location');
    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

//list.on('change',locationEmployees());
	function locationEmployees(){
		if($("#location").val() == '' ){
			alert('You must choose a location.');
		} else{
			$("#employees").html(transition);
			$.post(
				'/employee/reviewable',
				{
					period: $("#period").val(),
					location: $("#location").val(),
					_token: '{{ csrf_token() }}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#employees").html(data);	
					}
				}
				);
		}
		
	}
</script>


@endsection