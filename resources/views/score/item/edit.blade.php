@extends('layouts.master')
@section('content')
@include('score.nav')
<div class="container">
<h1>Item Edit</h1>




<form  method="POST" action="/score/item/{{ $item->id }}/update" class="col-4">
{{csrf_field()}}
<div class="form-group">
	{{Form::label('category','Category',['class'=>'mr-sm-2'])}}
	<div class="input-group">
 
	{{Form::select('category',$categories,$item->score_category_id,['placeholder'=>'Choose a category'])}}	
	</div>

</div>

<div class="form-group">
<lable for="item" class="mr-sm-2">Item Name</lable>
<div class="input-group">
<input name="item" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="员工考核类别名称" value="{{ $item->name }}" required>
</div>
</div>

<div class="form-group">
<lable for="value" class="mr-sm-2">Item Value （员工考核项目分值 （加分项目为正整数，减分项目为负整数）</lable>
<div class="input-group">
<input type="number" name="value" class="form-control mb-2 mr-sm-2 mb-sm-0" placeholder="" max="100" min="-100" step="1" value="{{$item->value}}" required>
</div>
</div>

<button type="submit" class="btn btn-warning">Update</button>
</form>


</div>



@endsection