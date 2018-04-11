<style>
div.paystubs {
  	 page-break-inside: avoid;
}
.table {
	font-size:10px;
}
p
{
	font-size:12px;
}
</style>

<div class="paystubs">

@if($logs)

@foreach($logs as $e)

<div class="paystubs">

@if($e->totalPay)
<div class="row">
<div class=" col-sm-12">
<p>{{$e->employee->cName}} {{$e->employee->firstName.','.$e->employee->lastName}} {{$e->employee->employeeNumber}} - 
{{ $e->location->name  }}, {{ $e->location->address }}, {{ $e->location->city }},  
{{ \Carbon\Carbon::createFromFormat('Y-m-d',$e->startDate)->format('M j') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d',$e->endDate)->format('M j, Y') }}
</p>

<table class="table table-sm">
	<thead>
		<tr><th>Rate</th><th>wk1</th><th>wk2</th><th>Overtime</th><th>Premium</th><th>HolidayPay</th><th>Gross Income</th><th>Vacation Pay</th><th>EI</th><th>CPP</th><th>Fed. Tax</th><th>Prov. Tax</th><th>Total Tax</th><th>Total Deductable</th><th>Cheque Amt.</th><th>Cheque #</th>
		</tr>
	</thead>
	<tbody>
		
			<tr>
				<td>{{ $e->rate/100}}</td>
				<td>{{ $e->week1}}</td>
				<td>{{ $e->week2}}</td>
				<td>{{$e->overtimePay}}</td>
				<td>{{$e->premiumPay}}</td>
				<td>{{$e->holidayPay}}</td>
				<td>{{$e->grossIncome}}</td>
				<td>{{  $e->vacationPay }}</td>
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
		<tr><th>Extra Rate</th><th>Extra Hours</th><th>Extra Pay</th><th>岗位津贴</th><th>小费</th><th>夜班</th><th>餐补</th><th>表现</th><th>浮动工资</th><th>应发现金</th>
		</tr>
	</thead>
	<tbody>
		
			<tr>
				<td>12</td>
				<td>{{$e->cashHour }}</td>
				<td>{{$e->cashPay/100}}</td>
				<td>{{round($e->position_rate * ($e->week1 + $e->week2 +$e->cashHour),2)}}</td>
				<td>{{round(round($e->tip * $e->hourlyTip,2) * ($e->week1 + $e->week2 + $e->cashHour),2)}}</td>
				
				<td>{{round($e->nightHours * $e->nightRate,2)}}</td>
				<td>{{ round($e->mealRate * ($e->week1 + $e->week2 + $e->cashHour),2) }}</td>
				<td>{{$e->performance*100}}%</td>
				<td>{{$e->variablePay}}</td>
				<td>{{$e->variablePay + $e->cashPay/100}}</td>


			</tr>
		
	</tbody>
</table>


	</div>
</div>
	@endif
	</div>
		@endforeach
@endif
