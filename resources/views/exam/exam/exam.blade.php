@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>View Exam</h1>

@if(isset($exam))

<table class="table table-sm">
	<thead><tr><th>Qid</th><th>Question</th><th>Correct Answer</th><th>Given Answer</th><th>Taken at</th><th>Questions</th><th>created by</th><th>created at</th><th>delete</th></tr></thead>
	<tbody>
	@foreach($exam->question as $q)
	<tr>
		<td><a href="/question/{{ $q->question_id }}/show">{{ $q->question_id }}</a></td>
		<td><a href="/question/{{ $q->question_id }}/show">{{ $q->question->body }}</a></td>
		<td>{{ $q->question->answer()->correct()->first()->answer}}</td>
		<td>{{ $q->answer }}</td>
		<td>{{ $q->taken }}</td>

	</tr>
	@endforeach
	</tbody>
</table>
@endif
<div class="form-group">
<a href="/exam/all" class="btn btn-secondary">Back</a>
</div>





</div>



@endsection