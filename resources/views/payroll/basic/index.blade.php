@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Payroll</h1>

@if($employees)
<table class="table table-sm">
	<thead>
		<tr><th>id</th><th>card</th><th>name</th><th>hours</th><th>rate</th><th>grossPay</th><th>regular</th><th>overtime</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Net Basic</th>
			<th>Position rate</th><th>Tip share</th><th>hourlyTip</th><th>mealRate</th><th>nightRate</th><th>nightHours</th>
			<th>performanceIndex</th><th>bonus</th>
			<th>Variable Pay</th>
		</tr>
	</thead>
	<tbody>
		@foreach($employees as $e)
			<tr>
				<td>{{$e->id}}</td>
				<td>{{$e->employeeNumber}}</td>
				<td>{{$e->cName}}</td>
				<td>{{round($e->hours->total,2)}}</td>
				<td>{{$e->grossPay->basicRate}}</td>
				<td>{{$e->grossPay->total}}</td>
				<td>{{$e->grossPay->regularPay}}</td>
				<td>{{$e->grossPay->overtimePay}}</td>
				
				<td>{{$e->basicPay[0]->EI}}</td>
				<td>{{$e->basicPay[0]->CPP}}</td>
				<td>{{$e->basicPay[0]->federalTax}}</td>
				<td>{{$e->basicPay[0]->provincialTax}}</td>
				<td>{{$e->basicPay[0]->net}}</td>

				<td>{{$e->job_location()->first()->job->rate/100}}</td>
				<td>{{$e->job_location()->first()->job->tip}}</td>
				<td>{{$e->magicNoodlePay->variablePay->hourlyTip}}</td>
				<td>{{$e->magicNoodlePay->variablePay->mealRate}}</td>
				<td>{{$e->magicNoodlePay->variablePay->nightRate}}</td>
				<td>{{$e->magicNoodlePay->variablePay->nightHours}}</td>
				<td>{{$e->magicNoodlePay->variablePay->performanceIndex}}</td>
				<td>{{$e->magicNoodlePay->variablePay->bonus}}</td>
				<td>{{$e->magicNoodlePay->variablePay->total}}</td>



			</tr>
		@endforeach
	</tbody>
</table>
@endif





<div class="form-group">
<a href="/payroll/basic" class="btn btn-secondary">Basic Pay</a>
</div>
<div class="form-group">
<a href="/payroll/variable" class="btn btn-secondary">Variable Pay</a>
</div>




</div>



@endsection