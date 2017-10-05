@extends('layouts.timeclock.master')
@section('content')

<section id="t4" class="container">
<h6>Year {{date('Y')}}</h6>
<h6>Employer's name</h6>
<p>Magic Noodle</p>
<h6><span>54</span> Employer's account number</h6>
<p>xxx-xxx-xxxx</p>

<h6><span>10</span> Province of employement</h6>
<p>ON</p>
<h6><span>12</span> Social insurance number</h6>
<p>{{ $employee->employeeNumber}}</p>

<h6>Employee's name and address</h6>
<h6>Last name (in capital letters)</h6>  
<p>{{ strtoupper($employee->lastName) }}</p>
<h6>First name</h6>  
<p>{{ strtoupper($employee->firstName) }}</p>

<h6><span>14</span> Employment income - line 101</h6>
<p>{{ $payrolls[1]['grossIncome'] }}</p>

<h6><span>16</span> Employee's CPP contributions - line 308</h6>
<p>{{ $payrolls[1]['CPP'] }}</p>

<h6><span>18</span> Employee's EI premiums - line 312</h6>
<p>{{ $payrolls[1]['EI'] }}</p>

<h6><span>22</span> Income tax deducted - line 437</h6>
<p>{{ $payrolls[1]['federalTax'] + $payrolls[1]['provincialTax'] }}</p>

<h6><span>24</span> EI insurable earnings </h6>
<p>{{ $payrolls[1]['grossIncome'] }}</p>

<h6><span>26</span> CPP/QPP pensionable earnings </h6>
<p>{{ $payrolls[1]['grossIncome'] }}</p>

<h6><span>29</span> Employment code </h6>
<p>1</p>

</section>


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
				<td>{{$w->cheque->EI}}</td>
				<td>{{$w->cheque->CPP}}</td>
				<td>{{$w->cheque->federalTax}}</td>
				<td>{{$w->cheque->provincialTax}}</td>
				<td>{{$w->cheque->net}}</td>
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