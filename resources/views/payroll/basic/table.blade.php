
@if($sum)
<table class="table table-sm">
	<thead>
		<tr><th>Total hrs</th><th>Overtime hrs</th><th>Gross</th>
			<th>EI</th><th>EI Company</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Cheque</th><th>Cash</th>
			<th>nightHrs</th>
			<th>bonus</th>
			<th>Variable Pay</th><th>total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ round($sum['totalHour'],2) }}</td>
			<td>{{ round($sum['overtimeHour'],2) }}</td>
			<td>{{ $sum['gross']/100 }}</td>
			<td>{{ $sum['EI']/100 }}</td>
			<td>{{ round($sum['EI']/100*1.4,2) }}</td>
			<td>{{ $sum['CPP']/100 }}</td>
			<td>{{ $sum['fedTax']/100 }}</td>
			<td>{{ $sum['pTax']/100 }}</td>
			<td>{{ $sum['cheque']/100 }}</td>
			<td>{{ $sum['cashPay']/100 }}</td>
			<td>{{ round($sum['nightHour'],2) }}</td>
			<td>{{ $sum['bonus']/100 }}</td>
			<td>{{ $sum['variable']/100 }}</td>
			<td>{{ $sum['total']/100 }}</td>
			
		</tr>
		<tr><th>BaseRate</th><th>nightRate</th><th>mealRate</th><th>HourlyTip</th><th>Employees</th></tr>
		<tr><td>{{ $sum['basicRate'] }}</td><td>{{ $sum['nightRate'] }}</td><td>{{ $sum['mealRate'] }}</td><td>{{ $sum['hourlyTip'] }}</td><td>{{ $sum['employees'] }}</td></tr>
</tbody>
@endif


@if($logs)
<table class="table table-sm">
	<thead>
		<tr><th>员工号</th><th>名字</th><th>legal</th><th>时薪</th><th>现金时</th><th>支票时</th><th>基本工资</th><th>加班</th><th>Holiday</th><th>Gross</th>
			<th>Vacation</th>
			<th>EI</th><th>CPP</th><th>FedTax</th><th>Prov.Tax</th><th>Tax</th><th>支票额度</th><th>现金工资</th>
			<th>浮动时薪</th><th>小费</th><th>夜班时</th><th>餐补</th>
			<th>浮动工资</th><th>发现</th><th>Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($logs as $e)
		 @if($e->totalPay)
			<tr>
				
				<td>{{$e->employee->employeeNumber}}</td>
				<td>{{$e->employee->cName}}</td>
				<td>{{$e->employee->firstName.' '.$e->employee->lastName}}</td>
				<td>{{ round($e->rate/100,2) }}</td>
				
				<td>{{$e->cashHour}}</td>
				<td>{{$e->week1 + $e->week2}}</td>
				
				<td>{{$e->regularPay}}</td>
				<td>{{$e->overtimePay}}</td>
				<td>{{$e->holidayPay}}</td>
				<td>{{$e->grossIncome}}</td>
				<td>{{$e->vacationPay}}</td>
				<td>{{$e->EI}}</td>
				<td>{{$e->CPP}}</td>
				<td>{{$e->federalTax}}</td>
				<td>{{$e->provincialTax}}</td>
				<td>{{$e->provincialTax + $e->federalTax }}</td>
				<td><strong>{{$e->cheque}}</strong></td>
				<td>{{$e->cashPay/100}}</td>

				<td>{{$e->position_rate}}</td>
				<td>{{ round($e->tip * $e->hourlyTip * ($e->week1 + $e->week2 + $e->cashHour),2)}}</td>
				
				<td>{{$e->nightHours}}</td>
				<td>{{ round($e->mealRate * ($e->week1 + $e->week2 + $e->cashHour),2) }}</td>
				<td>{{$e->variablePay}}</td>
				<th><strong>{{$e->variablePay + $e->cashPay/100}}</strong></th>
				<td>{{$e->totalPay}}</td>



			</tr>
			@endif
		@endforeach
	</tbody>
</table>
@endif

<!-- Modal -->
<div class="modal fade" id="chequeModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="chequeModalLabel">Cheque Number</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<label for="chequeNumberInput">Cheque Number</label>
        <input type="text" id="chequeNumberInput" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveChequeNumber()">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
var payrollID = '';
function addChequeNumber(payId){
	console.log('add cheque number for: '+ payId);
	payrollID = payId;
	$('#chequeModal').modal();
	
}

function saveChequeNumber(){
	$.post(
		'/payroll/chequeNumber',
		{
			_token: '{{csrf_token()}}',
			payrollLog: payrollID,
			chequeNumber: $('#chequeNumberInput').val()
		},
		function(data,status){
			if(status == 'success'){
				$('#cheque'+payrollID).html($('#chequeNumberInput').val());
			}
		}
		);
	$('#chequeModal').modal('hide')
}

</script>