@extends('layouts.timeclock.master')
@section('content')
<div class="container-fluid">
<h1>Employee Yearly Payroll</h1>

<main>

	<section>
		<h2>{{ $employee->cName}} - {{ $employee->employeeNumber}} </h2>
	</section>



@if($payrolls)



		@foreach($payrolls as $store)


<table class="table table-sm">
	<thead>
		<tr><th>RegularHr</th><th>Overtime</th><th>TotalHrs</th><th>regularPay</th><th>OvertimePay</th><th>Gross Income</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Cheque</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ $store['regular'] }}</td>
			<td>{{ $store['overtime'] }}</td>
			<td>{{ $store['totalHours'] }}</td>
			<td>{{ $store['regularPay'] }}</td>
			<td>{{ $store['overtimePay'] }}</td>
			<td>{{ $store['grossIncome'] }}</td>
			<td>{{ $store['EI'] }}</td>
			<td>{{ $store['CPP'] }}</td>
			<td>{{ $store['federalTax'] }}</td>
			<td>{{ $store['provincialTax'] }}</td>
			<td>{{ $store['cheque'] }}</td>
		</tr>
	</tbody>
</table>

<table class="table table-sm">
	<thead>
		<tr><th>WeekStart</th><th>WeekEnd</th><th>regular</th><th>overtime</th><th>Week Total</th><th>RegularPay</th><th>OvertimePay</th><th>Gross Income</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Cheque</th>
		</tr>
	</thead>
	<tbody>
			@foreach( $store['weeks'] as $w)
			<tr>
				
				<td>{{$w->weekStart}}</td>
				<td>{{$w->weekEnd}}</td>
				<td>{{$w->grossPay['regular']}}</td>
				<td>{{$w->grossPay['overtime']}}</td>
				<td>{{$w->hours}}</td>
				<td>{{$w->grossPay['regularPay']}}</td>
				<td>{{$w->grossPay['overtimePay']}}</td>
				<td>{{$w->grossPay['grossIncome']}}</td>
				<td>{{$w->cheque[0]->EI}}</td>
				<td>{{$w->cheque[0]->CPP}}</td>
				<td>{{$w->cheque[0]->federalTax}}</td>
				<td>{{$w->cheque[0]->provincialTax}}</td>
				<td>{{$w->cheque[0]->net}}</td>
			</tr>
			@endforeach
			</tbody>
</table>
		@endforeach

@endif




</main>




<div class="form-group">
<a href="/payroll/basic" class="btn btn-secondary">Basic Pay</a>
</div>
<div class="form-group">
<a href="/payroll/variable" class="btn btn-secondary">Variable Pay</a>
</div>




</div>




@endsection