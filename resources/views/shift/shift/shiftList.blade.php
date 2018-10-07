@if(count($shifts))
<table class="table table-responsive table-sm table-striped table-hover">
<thead>
<tr><th>Location</th><th>Employee</th><th>Role</th><th>Start</th><th>End</th><tr>
</thead>
<tbody>
	@foreach($shifts as $s)
	<tr>
		@if($s->location)
		<td>{{ $s->location->name }}</td>
		@else
		<td>N/A</td>
		@endif
		
		@if($s->employee)
		<td>{{ $s->employee->cName }}</td>
		@else
		<td>N/A</td>
		@endif
		<td>{{ $s->role->c_name }}</td>
		<td>{{ $s->start }}</td>
		<td>{{ $s->end }}</td>
	</tr>

	@endforeach
</tbody>
</table>

@else
<p>No scheduled shift</p>
@endif