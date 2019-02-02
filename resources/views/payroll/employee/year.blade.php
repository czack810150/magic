@extends('layouts.timeclock.master')
@section('content')
<main>

<h1>Employee Year</h1>
<h2>{{$employee->cName}}  {{$employee->lastName}}, {{$employee->firstName }} - {{$employee->employeeNumber}}</h2>

<table class="table table-sm">
	<thead>
		<tr><th>Regular Hrs</th><th>Overtime Hrs</th><th>RegularPay</th><th>OvertimePay</th><th>Gross Income</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Cheque</th><th>现金</th><th>净收入</th><th>人力成本</th>
		</tr>
	</thead>
	<tbody>
			
			<tr>
				<td>{{round($sum['regular'],2)}}</td>
				<td>{{round($sum['overtime'],2)}}</td>
				<td>{{$sum['regularPay']}}</td>
				<td>{{$sum['overtimePay']}}</td>
				
				<td>{{$sum['grossIncome']}}</td>
				<td>{{$sum['EI']}}</td>
				<td>{{$sum['CPP']}}</td>
				<td>{{$sum['federalTax']}}</td>
				<td>{{$sum['provincialTax']}}</td>
				<td>{{$sum['cheque']}}</td>
				<td>{{$sum['cash']}}</td>
				<td>{{$sum['net']}}</td>
				<td>{{$sum['cost'] }}</td>
			</tr>
			
			</tbody>
</table>


<table class="table table-sm">
	<thead>
		<tr><th>period Start</th><th>period End</th><th>week1</th><th>week2</th><th>Over1</th><th>Over2</th><th>RegularPay</th><th>OvertimePay</th><th>Premium</th><th>Holiday</th><th>Gross Income</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Cheque</th>
		</tr>
	</thead>
	<tbody>
			@foreach( $payrolls as $w)
			<tr>
				
				<td>{{$w->startDate}}</td>
				<td>{{$w->endDate}}</td>
				<td>{{$w->week1}}</td>
				<td>{{$w->week2}}</td>
				<td>{{$w->ot1}}</td>
				<td>{{$w->ot2}}</td>
		
				<td>{{$w->regularPay}}</td>
				<td>{{$w->overtimePay}}</td>
				<td>{{$w->premiumPay}}</td>
				<td>{{$w->holidayPay}}</td>
				<td>{{$w->grossIncome}}</td>
				<td>{{$w->EI}}</td>
				<td>{{$w->CPP}}</td>
				<td>{{$w->federalTax}}</td>
				<td>{{$w->provincialTax}}</td>
				<td>{{$w->cheque}}</td>
			</tr>
			@endforeach
			</tbody>
</table>





</main>




<div class="form-group">
<a href="/payroll/basic" class="btn btn-secondary">Basic Pay</a>
</div>
<div class="form-group">
<a href="/payroll/variable" class="btn btn-secondary">Variable Pay</a>
</div>
<div class="form-group">
<a href="/payroll/employee" class="btn btn-secondary">Employee</a>
</div>



</div>




@endsection