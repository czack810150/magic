@extends('layouts.master')
@section('content')
<main>

<h1>Location Year</h1>
<h2>{{$location->name}}  </h2>

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


</main>

@endsection