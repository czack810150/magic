<table class="table table-bordered table-small">
	<thead>
		<tr><th>Total</th>
			<th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th></tr>
	</thead>
	<tr>
		<td id="totalHour">{{ round($stats->sum('totalHour'),2) }}</td>
			@foreach($stats as $s)
				<td>{{ round($s['totalHour'],2) }}</td>
			@endforeach
	</tr>
</table>