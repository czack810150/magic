


@if($logs)

@foreach($logs as $e)
@if($e->totalPay)
<div class="row">
<div class=" col-sm-12">
<p>{{$e->employee->cName}} {{$e->employee->firstName.','.$e->employee->lastName}} {{$e->employee->employeeNumber}} - 
{{ $e->location->name  }}, {{ $e->location->address }}, {{ $e->location->city }},  
{{ \Carbon\Carbon::createFromFormat('Y-m-d',$e->startDate)->format('M j') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d',$e->endDate)->format('M j, Y') }}
</p>
<table class="table table-sm">
	<thead>
		<tr><th>Rate</th><th>Gross Income</th><th>EI</th><th>CPP</th><th>Federal Tax</th><th>Ontario Tax</th><th>Total Tax</th><th>Total Deductable</th><th>Cheque Amt.</th><th>Cheque #</th>
		</tr>
	</thead>
	<tbody>
		
			<tr>
				<td>{{ $e->rate/100}}</td>
				<td>{{$e->grossIncome}}</td>
				
				<td>{{$e->EI}}</td>
				<td>{{$e->CPP}}</td>
				<td>{{$e->federalTax}}</td>
				<td>{{$e->provincialTax}}</td>
				<td>{{$e->provincialTax +$e->federalTax }}</td>
				<td>{{$e->provincialTax +$e->federalTax + $e->CPP + $e->EI}} </td>
				<td>{{$e->cheque}}</td>
				<td></td>
			</tr>
		
	</tbody>
</table>
</div>
</div>


<div class="row">
	<div class=" col-sm-12">
		<table class="table table-sm">
	<thead>
		<tr><th>week 1</th><th>week 2</th><th>wk1 OT</th><th>wk2 OT</th><th>ReguarPay</th><th>OtPay</th><th>Premium</th><th>Holiday Pay</th><th>岗位津贴</th><th>小费</th><th>夜班</th><th>餐补</th><th>表现</th><th>浮动工资</th>
		</tr>
	</thead>
	<tbody>
		
			<tr>
				<td>{{$e->week1}}</td>
				<td>{{$e->week2}}</td>
				
				<td>{{$e->ot1}}</td>
				<td>{{$e->ot2}}</td>

				<td>{{$e->regularPay}}</td>
				<td>{{$e->overtimePay}}</td>
				<td>{{$e->premiumPay}}</td>
				<td>{{$e->holidayPay}}</td>
			

				<td>{{round($e->position_rate * ($e->week1 + $e->week2),2)}}</td>
				<td>{{round($e->tip * $e->hourlyTip * ($e->week1 + $e->week2),2)}}</td>
				
				<td>{{round($e->nightHours * $e->nightRate,2)}}</td>
				<td>{{ round($e->mealRate * ($e->week1 + $e->week2),2) }}</td>
				<td>{{number_format($e->performance,2)}}</td>
				<td>{{$e->variablePay}}</td>
			


			</tr>
		
	</tbody>
</table>
	</div>
</div>
	@endif
		@endforeach
@endif