
<table class="table">
	<thead><tr><th>Employee</th><th>Location</th><th>ClockIn</th><th>ClockOut</th></tr></thead>
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

			

			

		</tr>
		@endforeach
	</tbody>
</table>