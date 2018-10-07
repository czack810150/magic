@extends('layouts.master')
@section('content')
@include('score.nav')
<div class="container">
<h1>Create a new item</h1>




<form  method="POST" action="/score/item/store">
{{csrf_field()}}
<div class="form-group">
	{{Form::label('category','Category',['class'=>'mr-sm-2'])}}
	<div class="input-group">
 
	{{Form::select('category',$categories,null,['placeholder'=>'Choose a category'])}}	
	</div>

</div>

<div class="form-group">
<lable for="item" class="mr-sm-2">Employee Performance Item</lable>
<div class="input-group">
<input name="item" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="员工考核项目" required>
</div>
</div>
<div class="form-group">
<lable for="value" class="mr-sm-2">Item Value （员工考核项目分值 （加分项目为正整数，减分项目为负整数）</lable>
<div class="input-group">
<input type="number" name="value" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="" max="100" min="-100" step="1" value="0" required>
</div>
</div>

<button type="submit" class="btn btn-primary">Submit</button>
</form>


</div>



@endsection