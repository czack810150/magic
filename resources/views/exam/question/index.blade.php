@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Questions</h1>

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
<a href="/question" class="btn btn-secondary">All questions</a>
</div>
<div class="form-group">
<a href="/question/create" class="btn btn-secondary">New question</a>
</div>
<div class="form-group">
<a href="/question_category/create" class="btn btn-secondary">New question category</a>
</div>



</div>



@endsection