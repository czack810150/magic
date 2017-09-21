@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Create a new question</h1>


<div class="form-group">
<a href="/question" class="btn btn-secondary">View All questions</a>
<a href="#mc" class="btn btn-secondary btn-success" data-toggle="collapse" aria-expanded="false" aria-controls="collapseMC">Multiple choice</a>
<a href="#sa" class="btn btn-secondary btn-info" data-toggle="collapse" aria-expanded="false" aria-controls="collapseSA">Short answer</a>
</div>

<form  method="POST" action="/question/create" id="mc" class="collapse">
{{csrf_field()}}
<div class="form-group">
<lable for="category" class="mr-sm-2">Question Category</lable>
<div class="input-group">
<select name="category" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
@foreach($categories as $c)
<option value="{{$c->id}}">{{$c->name}}</option>
@endforeach
</select>
</div>
</div>

<div class="form-group">
<lable for="question" class="mr-sm-2">New Question</lable>
<div class="input-group">
<input type="text" name="question" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
</div>
</div>

<div class="form-group">
<lable for="question_level" class="mr-sm-2">Difficulty level (0-9)</lable>
<div class="input-group">
<input type="text" name="difficulty" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
</div>
</div>

<div class="form-group">
<lable for="correct_answer" class="mr-sm-2">Correct Answer</lable>
<div class="input-group">
<input type="text" name="correct_answer" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
</div>
</div>

<div class="form-group">
<lable for="wrong_answer1" class="mr-sm-2">Wrong Answer 1</lable>
<div class="input-group">
<input type="text" name="wrong_answer1" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
</div>
</div>

<div class="form-group">
<lable for="wrong_answer2" class="mr-sm-2">Wrong Answer 2</lable>
<div class="input-group">
<input type="text" name="wrong_answer2" class="form-control mb-2 mr-sm-2 mb-sm-0">
</div>
</div>

<div class="form-group">
<lable for="wrong_answer3" class="mr-sm-2">Wrong Answer 3</lable>
<div class="input-group">
<input type="text" name="wrong_answer3" class="form-control mb-2 mr-sm-2 mb-sm-0">
</div>
</div>
<button type="submit" class="btn btn-primary">Submit multiple choice question</button>
</form>


<form  method="POST" action="/question/createShortAnswer" id="sa" class="collapse">
{{csrf_field()}}
<div class="form-group">
<lable for="category" class="mr-sm-2">Question Category</lable>
<div class="input-group">
<select name="category" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
@foreach($categories as $c)
<option value="{{$c->id}}">{{$c->name}}</option>
@endforeach
</select>
</div>
</div>

<div class="form-group">
<lable for="question" class="mr-sm-2">New Question</lable>
<div class="input-group">
<input type="text" name="question" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
</div>
</div>

<div class="form-group">
<lable for="question_level" class="mr-sm-2">Difficulty level (0-9)</lable>
<div class="input-group">
<input type="text" name="difficulty" class="form-control mb-2 mr-sm-2 mb-sm-0" required>
</div>
</div>


<button type="submit" class="btn btn-primary">Submit short answer question</button>
</form>


</div>



@endsection