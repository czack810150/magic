@if($sum)

<table class="table table-sm">
	<thead>
		<tr><th>regular</th><th>overtime</th><th>gross</th><th>EI(公司）</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>cheque</th><th>Meal</th>
			<th>nightHour</th><th>nightPay</th><th>bonus</th><th>variable</th><th>total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ $sum['regularHour']}}</td>
			<td>{{ $sum['overtimeHour']}}</td>
			<td>{{ $sum['gross']}}</td>
			<td>{{ $sum['EI']*1.4}}</td>
			<td>{{ $sum['CPP']}}</td>
			<td>{{ $sum['fedTax']}}</td>
			<td>{{ $sum['pTax']}}</td>
			<td>{{ $sum['cheque']}}</td>
			<td>{{ $sum['meal']}}</td>
			<td>{{ $sum['nightHour']}}</td>
			<td>{{ $sum['nightPay']}}</td>
			<td>{{ $sum['bonus']}}</td>
			<td>{{ $sum['variable']}}</td>
			<td>{{ $sum['total']}}</td>
		</tr>
	</tbody>
</table>
@endif

@if($employees)
<table class="table table-sm">
	<thead>
		<tr><th>card</th><th>name</th><th>wk1</th><th>wk2</th><th>hours</th><th>regular</th><th>overtime</th><th>gross</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Cheque</th>
			<th>Position rate</th><th>Tip %</th><th>hourlyTip</th><th>mealRate</th><th>nightRate</th><th>nightHrs</th>
			<th>performance</th><th>bonus</th>
			<th>Variable Pay</th><th>total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($employees as $e)
			@if($e->job_location()->first()->job->hour && $e->magicNoodlePay->netPay )
			<tr>
				
				<td>{{$e->employeeNumber}}</td>
				<td>{{$e->cName}}</td>
				<td>{{$e->wk1['hours']}}</td>
				<td>{{$e->wk2['hours']}}</td>
				<td>{{$e->wk1['hours']+$e->wk2['hours']}}</td>
				
				
				<td>{{$e->magicNoodlePay->grossPay->regularPay}}</td>
				<td>{{$e->magicNoodlePay->grossPay->overtimePay}}</td>
				<td>{{$e->magicNoodlePay->grossPay->total}}</td>
				
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
			@endif
		@endforeach
	</tbody>
</table>
@endif