@extends('layouts.master')
@section('content')
<div class="container">
<h1>View Exam</h1>

@if(isset($exam))

<table class="table table-sm">
	<thead><tr><th>Qid</th><th>Question</th><th>Correct Answer</th><th>Given Answer</th></tr></thead>
	<tbody>
	@foreach($exam->question as $q)
	<tr>
		<td><a href="/question/{{ $q->question_id }}/show">{{ $q->question_id }}</a></td>
		<td><a href="/question/{{ $q->question_id }}/show">{{ $q->question->body }}</a></td>
		<td>
			@if(isset($q->question->answer()->correct()->first()->answer))
			{{ $q->question->answer()->correct()->first()->answer}}
			@else 
			<div class="alert alert-secondary">简答题</div>
			@endif

		</td>

		@if(isset($q->answer->answer))
		<td>{{ $q->answer->answer }}</td>
		@else 
		<td>{{ $q->short_answer }}</td>
		@endif
		

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