@extends('layouts.master')
@section('content')

@include('exam.question.nav')



@if(isset($questions))

<table class="table table-sm">
	<thead><tr><th>id</th><th>Category</th><th>Question</th><th>difficulty</th><th>created by</th><th>created at</th><th>delete</th></tr></thead>
	<tbody>
	@foreach($questions as $q)
	<tr>
		<td><a href="/question/{{ $q->id }}/show">{{ $q->id }}</a></td>
		
		@if($q->question_category)
		<td><a href="/question_category/{{$q->question_category_id}}">{{ $q->question_category->name}}</a></td>
		@else
		<td></td>
		@endif
		<td><a href="/question/{{ $q->id }}/show">{{ $q->body }}</a> ({{ $q->mc?'选择题':'简答题' }})</td>
		<td>{{ $q->difficulty }}</td>
		<td>{{ $q->created_by }}</td>
		<td>{{ $q->created_at }}</td>
		<td><a href="/question/{{$q->id}}/delete">delete</a></td>

	</tr>
	@endforeach
	</tbody>
</table>
@endif

@endsection