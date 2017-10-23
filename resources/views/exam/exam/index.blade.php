@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Exams</h1>

@if(isset($questions))

<table class="table table-sm">
	<thead><tr><th>id</th><th>Question</th><th>Category</th><th>difficulty</th><th>created by</th><th>created at</th><th>delete</th></tr></thead>
	<tbody>
	@foreach($questions as $q)
	<tr>
		<td><a href="/question/{{ $q->id }}/show">{{ $q->id }}</a></td>
		<td><a href="/question/{{ $q->id }}/show">{{ $q->body }}</a></td>
		<td><a href="/question_category/{{$q->question_category->id}}">{{ $q->question_category->name}}</a></td>
		<td>{{ $q->difficulty }}</td>
		<td>{{ $q->created_by }}</td>
		<td>{{ $q->created_at }}</td>
		<td><a href="/question/{{$q->id}}/delete">delete</a></td>

	</tr>
	@endforeach
	</tbody>
</table>
@endif
<div class="form-group">
<a href="/exam/all" class="btn btn-secondary">All exams</a>
</div>
<div class="form-group">
<a href="/exam/attemptedExams" class="btn btn-secondary">Attempted exams</a>
</div>
<div class="form-group">
<a href="/exam/create" class="btn btn-secondary">Create an exam</a>
</div>




</div>



@endsection