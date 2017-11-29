@if(count($logs))
<table class="table table-sm table-hover">
<thead>
	<tr><th>Start</th><th>End</th><th>排班</th><th>有效</th><th>第一周排班</th><th>第二周排班</th><th>第一周打卡</th><th>第二周打卡</th><th>第一周有效</th><th>第二周有效</th><th>第一周超时</th><th>第二周超时</th><th>第一周夜班</th><th>第二周夜班</th></tr>
</thead>
<tbody>
	@foreach($logs as $h)
	<tr>
		<td>{{ $h->start }}</td>
		<td>{{ $h->end }}</td>
		<td class="alert alert-primary">{{ $h->wk1Scheduled +$h->wk2Scheduled  }}</td>
		<td class="alert alert-success">{{ $h->wk1Effective +$h->wk2Effective  }}</td>
		<td>{{ $h->wk1Scheduled }}</td>
		<td>{{ $h->wk2Scheduled }}</td>
		<td>{{ round($h->wk1Clocked,2) }}</td>
		<td>{{ round($h->wk2Clocked,2) }}</td>
		<td class="alert alert-primary">{{ $h->wk1Effective }}</td>
		<td class="alert alert-primary">{{ $h->wk2Effective }}</td>
		
		<td class="alert alert-danger">{{ $h->wk1Overtime }}</td>
		<td class="alert alert-danger">{{ $h->wk2Overtime }}</td>
		<td class="alert alert-dark">{{ $h->wk1Night }}</td>
		<td class="alert alert-dark">{{ $h->wk2Night }}</td>
	</tr>
	@endforeach
</tbody>
</table>
@else
<p>No data</p>
@endif