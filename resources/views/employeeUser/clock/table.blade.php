@if(count($logs))
<table class="table table-sm table-hover">
<thead>
	<tr><th>Location</th><th>打上</th><th>打下</th><th>时长</th><th>备注</th></tr>
</thead>
<tbody>
	@foreach($logs as $h)
	<tr>
		<td>{{ $h->location->name }}</td>
		<td>{{ $h->clockIn }}</td>
		<td>{{ $h->clockOut }}</td>
		<td>{{ round(Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$h->clockOut)->diffInSeconds(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$h->clockIn))/3600,2) }}</td>
		<td>{{ $h->comment }}</td>
	</tr>
	@endforeach
</tbody>
</table>
@else
<p>No data</p>
@endif