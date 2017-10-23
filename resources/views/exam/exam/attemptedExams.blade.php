@extends('layouts.master')
@section('content')
<div class="container">
<h1>Attempted Exams</h1>

@if(isset($exams))

<table class="table table-sm table-striped">
	<thead><tr><th>Name</th><th>Employee</th><th>Score</th><th>Taken at</th><th>Questions</th></tr></thead>
	<tbody>
	@foreach($exams as $e)
	<tr>
		
		<td><a href="/exam/{{ $e->id }}/mark">{{ $e->name }}</a></td>
		<td><a href="/employee/{{ $e->employee->id }}/show">{{ $e->employee->cName }}</a></td>
		<td>{{ $e->score }}</td>
		<td>{{ $e->taken_at }}</td>
		<td>{{ count($e->question) }}</td>
		
		

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
