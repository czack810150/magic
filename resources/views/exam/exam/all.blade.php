@extends('layouts.master')
@section('content')
<div class="container">
<h1>View All Exams</h1>

@if(isset($exams))

<table class="table table-sm">
	<thead><tr><th>id</th><th>Name</th><th>Employee</th><th>Score</th><th>Taken at</th><th>Questions</th><th>access</th><th>created by</th><th>created at</th><th>updated at</th><th>delete</th></tr></thead>
	<tbody>
	@foreach($exams as $e)
	<tr>
		<td><a href="/exam/{{ $e->id }}/show">{{ $e->id }}</a></td>
		<td><a href="/exam/{{ $e->id }}/show">{{ $e->name }}</a></td>
		<td><a href="/employee/{{ $e->employee->id }}/show">{{ $e->employee->cName }}</a></td>
		<td>{{ $e->score }}</td>
		<td>{{ $e->taken }}</td>
		<td>{{ count($e->question) }}</td>
		<td>{{$e->access}}</td>
		<td>creator</td>
		<td>{{ $e->created_at }}</td>
		<td>{{ $e->created_at }}</td>
		<td><a href="/exam/{{$e->id}}/delete">delete</a></td>

	</tr>
	@endforeach
	</tbody>
</table>
@endif
<div class="form-group">
<a href="/exam" class="btn btn-secondary">Back</a>
</div>





</div>



@endsection