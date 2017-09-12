@extends('layouts.timeclock.master')
@section('content')

<div class="container">
<div class="row  scanner justify-content-center" >

<div class="jumbotron">
	@if($result)
	
	<h1 class="display-3 {{$inout?"alert-success":"alert-danger"}}">员工{{$employee->cName}} {{$inout?"开始上班":"结束工作"}}</h1>
	<p class="lead"> </p>
	@else
	<h1 class="display-3 alert-warning">{{$employee->cName}} 已打过{{$inout?"上班":"下班"}}卡</h1>
	@endif
  
  
  <hr class="my-4">
  <p>{{$inout?"Work hard!":"Play hard!"}}</p>

  @if($shifts)
  <p>Your shifts today</p>
  	<table class="table">
  	<thead>
  	<tr><th>Scheduled In</th><th>Scheduled Out</th><th>Actual In</th><th>Actual Out</th></tr>
  	</thead>
  	<tbody>
  	@foreach($shifts as $s)
  	<tr>
  	<td>{{$s->scheduleIn}}</td>
  	<td>{{$s->scheduleOut}}</td>
  	<td>{{$s->clockIn}}</td>
  	<td>{{$s->clockOut}}</td>
	</tr>
  	@endforeach
  	</tbody>
  	</table>
  @endif

  <p class="lead">
    <a class="btn btn-primary btn-lg" href="/timeclock/" role="button">返回</a>
  </p>
</div>

</div>
</div>
@section('end')