
<table class="table">
	<thead><tr><th>Employee</th><th>Location</th><th>ClockIn</th><th>ClockOut</th><th>Edit</th></tr></thead>
	<tbody>
		@foreach($clocks as $c)
		<tr>
			@if($c->employee)
			<td>{{$c->employee->cName}}</td>
			@else
			<td></td>
			@endif
			<td>{{$c->location->name}}</td>
			<td>{{$c->clockIn}}</td>
			<td>{{$c->clockOut}}</td>
			<td><button type="button" class="btn btn-primary" onclick="editClock('{{ $c->id }}')">Edit</button></td>

			

			

		</tr>
		@endforeach
	</tbody>
</table>