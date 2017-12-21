@if(count($logs))
<table class="table table-sm">
	<thead><tr><th>Date</th><th>Employee</th><th>Event</th><th>Result</th></tr></thead>
	<tbody>
	@foreach($logs as $log)
		<tr>
			<td>{{ $log->date }}</td>
			<td>{{ $log->employee->cName }}</td>
			<td>{{ $log->score_item->name }}</td>
			<td>{{ $log->score_item->value }}</td>
		</tr>
	@endforeach
</tbody>
</table>
@else
<div class="alert m-alert--default">No performance data.</div>
@endif