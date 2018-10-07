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
													Paystubs
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
		<tr><th>Location</th><th>Start</th><th>End</th><th>Hours</th><th>Salary</th><th>Overtime</th><th>Vacation Pay</th><th>Holiday</th><th>Gross Income</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Tax</th><th>Cheque</th>
			
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
				<td>{{$e->vacationPay}}</td>
				<td>{{$e->holidayPay}}</td>
				<td>{{$e->grossIncome}}</td>
				<td>{{$e->EI}}</td>
				<td>{{$e->CPP}}</td>
				<td>{{$e->federalTax}}</td>
				<td>{{$e->provincialTax}}</td>
				<td>{{$e->provincialTax +$e->federalTax }}</td>
				<td>{{$e->cheque}}</td>		
				
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
				'/payroll/employee/paystub/year',
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