@extends('layouts.timeclock.master')
@section('content')
<div class="container-fluid">
<h1>Payroll</h1>
<form class="form-inline">

	
		<div class="form-group">
		<label class="mr-sm-2" for="location">Location</label>
{{ Form::select('location',$locations,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder' => 'Choose a location','id'=>'location'])}}
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('dateRange','Date range',['class'=>'mx-sm-3'])}}
			{{ Form::select('dateRange',$dates,null,['class'=>'custom-select mb-2 mr-sm-2 mb-sm-0','placeholder'=>'Choose date range']) }}
		</div>
		{{ Form::button('View',['class'=>'btn btn-primary','onclick'=>'viewLocationDate()']) }}
		{{csrf_field()}}

</form>

<main id="payroll">
@if($employees)
<table class="table table-sm">
	<thead>
		<tr><th>id</th><th>card</th><th>name</th><th>wk1</th><th>wk2</th><th>hours</th><th>rate</th><th>grossPay</th><th>regular</th><th>overtime</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Net Basic</th>
			<th>Position rate</th><th>Tip share</th><th>hourlyTip</th><th>mealRate</th><th>nightRate</th><th>nightHours</th>
			<th>performanceIndex</th><th>bonus</th>
			<th>Variable Pay</th><th>total Net</th>
		</tr>
	</thead>
	<tbody>
		@foreach($employees as $e)
			<tr>
				<td>{{$e->id}}</td>
				<td>{{$e->employeeNumber}}</td>
				<td>{{$e->cName}}</td>
				<td>{{$e->wk1['hours']}}</td>
				<td>{{$e->wk2['hours']}}</td>
				<td>{{$e->wk1['hours']+$e->wk2['hours']}}</td>
				<td>{{$e->magicNoodlePay->grossPay->basicRate}}</td>
				<td>{{$e->magicNoodlePay->grossPay->total}}</td>
				<td>{{$e->magicNoodlePay->grossPay->regularPay}}</td>
				<td>{{$e->magicNoodlePay->grossPay->overtimePay}}</td>
				
				<td>{{$e->magicNoodlePay->basicPay->EI}}</td>
				<td>{{$e->magicNoodlePay->basicPay->CPP}}</td>
				<td>{{$e->magicNoodlePay->basicPay->federalTax}}</td>
				<td>{{$e->magicNoodlePay->basicPay->provincialTax}}</td>
				<td>{{$e->magicNoodlePay->basicPay->net}}</td>

				<td>{{$e->job_location()->first()->job->rate/100}}</td>
				<td>{{$e->job_location()->first()->job->tip}}</td>
				<td>{{$e->magicNoodlePay->variablePay->hourlyTip}}</td>
				<td>{{$e->magicNoodlePay->variablePay->mealRate}}</td>
				<td>{{$e->magicNoodlePay->variablePay->nightRate}}</td>
				<td>{{$e->magicNoodlePay->variablePay->nightHours}}</td>
				<td>{{$e->magicNoodlePay->variablePay->performanceIndex}}</td>
				<td>{{$e->magicNoodlePay->variablePay->bonus}}</td>
				<td>{{$e->magicNoodlePay->variablePay->total}}</td>
				<td>{{$e->magicNoodlePay->basicPay->net+$e->magicNoodlePay->variablePay->total}}</td>



			</tr>
		@endforeach
	</tbody>
</table>
@endif
</main>




<div class="form-group">
<a href="/payroll/basic" class="btn btn-secondary">Basic Pay</a>
</div>
<div class="form-group">
<a href="/payroll/variable" class="btn btn-secondary">Variable Pay</a>
</div>




</div>


<script>

	let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

	function viewLocationDate(){
		if($("#location").val() == '' || $("#dateRange").val()== ''){
			alert('You must choose a location and a date range.');
		} else{
			$("#payroll").html(transition);
			$.post(
				'/payroll/fetch',
				{
					location: $("#location").val(),
					startDate: $("#dateRange").val(),
					_token: $("input[name=_token]").val()
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