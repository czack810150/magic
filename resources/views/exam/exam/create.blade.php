@extends('layouts.master')
@section('content')
<script src="{{URL::asset('js/magic.js')}}"></script>
<div class="container">
	<h1>Create a new exam</h1>
<div class="row">
<div class="col-md-6">



<div class="form-group">
@include('layouts.locationFilter')
</div>
<div class="form-group" id="employeeList">
</div>



<form  method="POST" action="/exam/create"  class="">
{{csrf_field()}}
<input type="text" id="creator" name="creator" value="{{ Auth()->user()->authorization->employee_id }}" hidden>


<div class="form-group">
<lable for="question" class="mr-sm-2">Exam Name</lable>
<div class="input-group">
<input type="text" id="exam_name" name="exam_name" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
</div>
</div>

<div class="form-group">
<lable for="category" class="mr-sm-2">Question Category</lable>
<div class="input-group">
<select name="category" class="form-control" id="category">
@foreach($categories as $c)
<option value="{{$c->id}}">{{$c->name}}</option>
@endforeach
</select>
</div>
</div>

<ul class="list-unstyled" id="questions">
	@if(isset($questions))
		@foreach($questions as $q)
		<li onclick="selectQuestion($(this))" data-id="{{ $q->id }}">{{ $q->body }} ({{ $q->mc?"选择题":"简答题" }})</li>
		@endforeach
	@endif

</ul>



<a href="javascript:;" class="btn btn-primary" onclick="attemptSubmit()">Create Exam</a>
</form>

</div>

<div class="col-md-6">
	<ol id="selectedQuestions">
	</ol>
</div>
</div>

</div>

<script>
	document.addEventListener('DOMContentLoaded',function(){
		
		

		var location = $("#locationFilter");
		location.on('change',function(){
			locationEmployees();
		});

		var category = $('#category');
		category.on('change',function(){
			questionsByCategory($(this).val());
		});

		

	},false);
</script>


@endsection