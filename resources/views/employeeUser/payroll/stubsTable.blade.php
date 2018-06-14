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