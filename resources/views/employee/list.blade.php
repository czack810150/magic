<table class="table table-hover">
	<thead>
		<tr>
			<th>Employee</th><th>Username</th><th>Role</th><th>Date Hired</th>
		</tr>
	</thead>
	<tbody>
@foreach($employees as $e)

<tr onclick="viewEmployee('{{ $e->id }}')">
	<td>{{$e->cName}}<br>{{$e->employeeNumber}}<br>{{$e->job->rank}}</td>
	@if(isset($e->authorization->user->name))
	<td>{{ $e->authorization->user->name }}</td>
	<td>{{ $e->authorization->type }}</td>
	@else
	<td></td>
	<td></td>
	@endif
	<td>{{$e->hired->toFormattedDateString()}}</td>
</tr>

@endforeach
	</tbody>
</table>