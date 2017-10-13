
@if($sum)
<table class="table table-sm">
	<thead>
		<tr><th>regular hrs</th><th>overtime hrs</th><th>gross</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Cheque</th>
			<th>nightHrs</th>
			<th>bonus</th>
			<th>Variable Pay</th><th>total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ round($sum['regularHour'],2) }}</td>
			<td>{{ round($sum['overtimeHour'],2) }}</td>
			<td>{{ $sum['gross']/100 }}</td>
			<td>{{ $sum['EI']/100 }}</td>
			<td>{{ $sum['CPP']/100 }}</td>
			<td>{{ $sum['fedTax']/100 }}</td>
			<td>{{ $sum['pTax']/100 }}</td>
			<td>{{ $sum['cheque']/100 }}</td>
			<td>{{ round($sum['nightHour'],2) }}</td>
			<td>{{ $sum['bonus']/100 }}</td>
			<td>{{ $sum['variable']/100 }}</td>
			<td>{{ $sum['total']/100 }}</td>
		</tr>
</tbody>
@endif


@if($logs)
<table class="table table-sm">
	<thead>
		<tr><th>card</th><th>name</th><th>wk1</th><th>wk2</th><th>hours</th><th>regular</th><th>overtime</th><th>Premium</th><th>Holiday</th><th>gross</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Cheque</th>
			<th>Position rate</th><th>Tip %</th><th>hourlyTip</th><th>mealRate</th><th>nightRate</th><th>nightHrs</th>
			<th>performance</th><th>bonus</th>
			<th>Variable Pay</th><th>total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($logs as $e)
		 @if($e->totalPay)
			<tr>
				
				<td>{{$e->employee->employeeNumber}}</td>
				<td>{{$e->employee->cName}}</td>
				<td>{{$e->week1}}</td>
				<td>{{$e->week2}}</td>
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
				<td>{{$e->cheque}}</td>

				<td>{{$e->position_rate}}</td>
				<td>{{$e->tip}}</td>
				<td>{{$e->hourlyTip}}</td>
				<td>{{$e->mealRate}}</td>
				<td>{{$e->nightRate}}</td>
				<td>{{$e->nightHours}}</td>
				<td>{{$e->performance}}</td>
				<td>{{$e->bonus}}</td>
				<td>{{$e->variablePay}}</td>
				<td>{{$e->totalPay}}</td>



			</tr>
			@endif
		@endforeach
	</tbody>
</table>
@endif