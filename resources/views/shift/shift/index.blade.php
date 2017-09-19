@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<h1>Scheduled Shifts</h1>

<lable for="dateRange">Choose Period</lable>
<input type="text" name="dateRange" class="form-control"/>
{{csrf_field()}}

<div id="shiftTable">
</div>



</div>



@endsection