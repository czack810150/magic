@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-time-2"></i>
												</span>
												<h3 class="m-portlet__head-text">
													工时详情
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												
												<li class="m-portlet__nav-item">
{{ Form::select('year',$dates,$currentYear,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'year']) }}
												</li>
												<li class="m-portlet__nav-item">
														{{ Form::button('View',['class'=>'btn btn-primary','onclick'=>'viewEmployeeHour()']) }}
												</li>
										
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<main id="hours">
@if(count($logs))
<table class="table table-sm table-hover">
<thead>
	<tr><th>Location</th><th>Start</th><th>End</th><th>排班</th><th>有效</th><th>第一周排班</th><th>第二周排班</th><th>第一周打卡</th><th>第二周打卡</th><th>第一周有效</th><th>第二周有效</th><th>第一周超时</th><th>第二周超时</th><th>第一周夜班</th><th>第二周夜班</th></tr>
</thead>
<tbody>
	@foreach($logs as $h)
	<tr>
		<td>{{  $h->location->name }}</td>
		<td>{{ $h->start }}</td>
		<td>{{ $h->end }}</td>
		<td class="alert alert-primary">{{ $h->wk1Scheduled +$h->wk2Scheduled  }}</td>
		<td class="alert alert-success">{{ $h->wk1Effective +$h->wk2Effective  }}</td>
		<td>{{ $h->wk1Scheduled }}</td>
		<td>{{ $h->wk2Scheduled }}</td>
		<td>{{ round($h->wk1Clocked,2) }}</td>
		<td>{{ round($h->wk2Clocked,2) }}</td>
		<td class="alert alert-primary">{{ $h->wk1Effective }}</td>
		<td class="alert alert-primary">{{ $h->wk2Effective }}</td>
		
		<td class="alert alert-danger">{{ $h->wk1Overtime }}</td>
		<td class="alert alert-danger">{{ $h->wk2Overtime }}</td>
		<td class="alert alert-dark">{{ $h->wk1Night }}</td>
		<td class="alert alert-dark">{{ $h->wk2Night }}</td>
	</tr>
	@endforeach
</tbody>
</table>
@else
<p>No data</p>
@endif
										</main>
									</div>
								</div>
								<!--end::Portlet-->

<script>
    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

	function viewEmployeeHour(){
		
			$("#hours").html(transition);
			$.post(
				'/hours/employee/year',
				{
					location: $("#location").val(),
					year: $("#year").val(),
					_token: '{{csrf_token()}}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#hours").html(data);	
					}
				}
				);
		
	}
</script>
@endsection