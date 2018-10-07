@extends('layouts.master')
@section('content')
@include('score.nav')
<div class="container">
<h1>Create a new category</h1>




<form  method="POST" action="/score/category/create">
{{csrf_field()}}
<div class="form-group">
<lable for="category" class="mr-sm-2">Employee Performance Category</lable>
<div class="input-group">
<input name="category" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="员工考核类别名称" required>
</div>
</div>

<button type="submit" class="btn btn-primary">Submit</button>
</form>


</div>



@endsection