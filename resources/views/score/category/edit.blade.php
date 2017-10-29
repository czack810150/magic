@extends('layouts.master')
@section('content')
@include('score.nav')
<div class="container">
<h1>Category Edit</h1>




<form  method="POST" action="/score/category/{{ $category->id }}/update">
{{csrf_field()}}
<div class="form-group">
<lable for="category" class="mr-sm-2">Edit Employee Performance Category</lable>
<div class="input-group">
<input name="category" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="员工考核类别名称" value="{{ $category->name }}" required>
</div>
</div>

<button type="submit" class="btn btn-warning">Update</button>
</form>


</div>



@endsection