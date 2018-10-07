@if(count($shifts))
<table class="table table-sm">
<thead>
	<tr><th>Location</th><th>Scheduled Hours</th><th>Start</th><th>End</th><th>Role</th><th>Duty</th><th>comment</th></tr>
</thead>
<tbody>
	@foreach($shifts as $s)
	<tr>
		<td>{{$s->location->name}}</td>
		<td>{{ round($s->start->diffInSeconds($s->end)/3600,2) }}</td>
		<td>{{$s->start}}</td>
		<td>{{$s->end}}</td>
		<td>{{$s->role->c_name}}</td>
		@if($s->duty)
		<td>{{$s->duty->cName}}</td>
		@else
		<td></td>
		@endif
		<td>{{$s->comment}}</td>
	</tr>
	@endforeach
</tbody>
</table>
@else
No scheduled shifts
@endif