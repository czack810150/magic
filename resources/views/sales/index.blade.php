@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Sales</h1>


<form class="form-inline">

<div class="form-group">
<lable for="dateRange" class="mr-sm-2">Choose Period</lable>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
<input type="text" name="dateRange" class="form-control mb-2 mr-sm-2 mb-sm-0">
</div>
</div>

<div class="form-group">
    <label for="locationPicker" class="mr-sm-2">Choose Location</label>
  <!--   <div class="input-group">
    	<div class="input-group-addon"><i class="fa fa-briefcase"></i></div> -->
    <select class="form-control" id="locationPicker">
    
    @foreach($locations as $l)
      <option value="{{$l->id}}">{{ $l->name }}</option>
     @endforeach
    
    </select>
<!--   </div> -->
</div>


{{csrf_field()}}
</form>


<div id="shiftTable">
</div>



</div>



@endsection