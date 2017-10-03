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