@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
		<div class="m-portlet m-portlet--responsive-mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-users m--font-brand"></i>
						</span>
						<h3 class="m-portlet__head-text m--font-brand">
							Overview
						</h3>
					</div>			
				</div>
				<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location'])}}											
												</li>								
											</ul>
			</div>
			</div>
			<div class="m-portlet__body" id="scheduleReport">
				<ul class="list-unstyled">
					<li>Active: {{ $data['activeEmployees'] }}</li>
					<li>Terminated: {{ $data['terminatedEmployees'] }}</li>
					<ul>
						@foreach($data['positionBreakdown'] as $p )
							<li>{{$p->rank}} : {{$p->count}}</li>
						@endforeach
					</ul>
				</ul>
			</div>
		</div>	
		<!--end::Portlet-->

<script>
	let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';
	function viewLocationPerformance(){
		if($("#location").val() == '' || $("#dateRange").val()== ''){
			alert('You must choose a location and a year.');
		} else{
			$("#scheduleReport").html(transition);
			$.post(
				'/store/report/schedule',
				{
					location: $("#location").val(),
					year: $("#year").val(),
					frequency: $('#frequency').val(),
					_token: '{{csrf_token()}}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#scheduleReport").html(data);	
					}
				}
				);
		}
	}


</script>	



@endsection