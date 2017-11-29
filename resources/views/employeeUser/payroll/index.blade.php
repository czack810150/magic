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
													工资详情
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												
												<li class="m-portlet__nav-item">
{{ Form::select('year',$dates,$currentYear,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','id'=>'year']) }}
												</li>
												<li class="m-portlet__nav-item">
														{{ Form::button('View',['class'=>'btn btn-primary','onclick'=>'viewYear()']) }}
												</li>
										
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<main id="payroll">
@if(count($logs))
<table class="table table-sm table-striped">
	<thead>
		<tr><th>门店</th><th>期首</th><th>期末</th><th>工时</th><th>基本工资</th><th>超时工资</th><th>Premium</th><th>Holiday</th><th>税前收入</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Tax</th><th>支票</th>
			<th>岗位津贴</th><th>小时小费</th><th>夜班时间</th>
			<th>表现</th><th>餐补</th>
			<th>浮动工资</th><th>净收入</th>
		</tr>
	</thead>
	<tbody>
		@foreach($logs as $e)
		 @if($e->totalPay)
			<tr>
				<td>{{  $e->location->name }}</td>
				<td>{{$e->startDate}}</td>
				<td>{{$e->endDate}}</td>
				<td>{{$e->week1 + $e->week2}}</td>
				<td>{{$e->regularPay}}</td>
				<td>{{$e->overtimePay}}</td>
				<td>{{$e->premiumPay}}</td>
				<td>{{$e->holidayPay}}</td>
				<td>{{$e->grossIncome}}</td>
				<td>{{$e->EI}}</td>
				<td>{{$e->CPP}}</td>
				<td>{{$e->federalTax}}</td>
				<td>{{$e->provincialTax}}</td>
				<td>{{$e->provincialTax +$e->federalTax }}</td>
				<td>{{$e->cheque}}</td>		
				<td>{{$e->position_rate}}</td>
				<td>{{ round($e->tip * $e->hourlyTip,2)}}</td>
				<td>{{$e->nightHours}}</td>
				<td>{{$e->performance}}</td>
				<td>{{ round($e->mealRate * ($e->week1 + $e->week2),2) }}</td>
				<td>{{$e->variablePay}}</td>
				<td>{{$e->totalPay}}</td>
			</tr>
			@endif
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

	function viewYear(){
		
			$("#payroll").html(transition);
			$.post(
				'/payroll/employee/year',
				{
					location: $("#location").val(),
					year: $("#year").val(),
					_token: '{{csrf_token()}}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#payroll").html(data);	
					}
				}
				);
		
	}
</script>
@endsection