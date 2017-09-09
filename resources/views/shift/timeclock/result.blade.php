@extends('layouts.timeclock.master')
@section('content')

<div class="container">
<div class="row  scanner justify-content-center" >

<div class="jumbotron">
  <h1 class="display-3 {{$inout?"alert-success":"alert-danger"}}">员工{{$employee->cName}} {{$inout?"开始上班":"结束工作"}}</h1>
  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <hr class="my-4">
  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>

  @if($shifts)
  <p>You have shifts today.</p>
  	@foreach($shifts as $s)

  	<p>{{$s->scheduleIn}}</p>
  	<p>{{$s->scheduleOut}}</p>

  	@endforeach
  @endif

  <p class="lead">
    <a class="btn btn-primary btn-lg" href="/timeclock/" role="button">返回</a>
  </p>
</div>

</div>
</div>
@section('end')