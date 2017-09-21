@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Question Categories</h1>

@if(isset($categories))

<ul class="list-unstyled">
	@foreach($categories as $c)
	<li>{{$c->name}}  <a href="/question_category/{{$c->id}}/delete">delete</a></li>
	@endforeach
</ul>
@endif


<form class="form-inline" method="POST" action="/question_category/store">
{{csrf_field()}}
<div class="form-group">
<lable for="dateRange" class="mr-sm-2">New Category</lable>
<div class="input-group">
<input type="text" name="category" class="form-control mb-2 mr-sm-2 mb-sm-0">
</div>
</div>

<button type="submit" class="btn btn-primary">Submit</button>


</form>
<br>
<div class="form-group">
<a href="/question" class="btn btn-secondary">Back to questions</a>
</div>


</div>



@endsection