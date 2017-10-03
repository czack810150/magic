
@extends('layouts.timeclock.master')
@section('content')

<div class="container">
<div class="row  scanner justify-content-center" >

<div class="jumbotron">

	@if($result)
  <h1 class="display-3">{{$inout?"Hello":"Good Bye"}}, {{$employee->cName}}!</h1>
	<h1 class="display-4">
  <span class="badge {{$inout?"badge-success":"badge-danger"}}">{{$inout?"开始上班":"结束工作"}}</span>
  </h1>
	
	@else
  <h1 class="display-3">{{$employee->cName}}</h1>
  <h1 class="display-4">
  <span class="badge badge-warning">已打过{{$inout?"上班":"下班"}}卡</span></h1>
	@endif

  @if(isset($forgotten))

  <div class="card">
    <div class="card-body">
      <h3 class="card-title mb-3"><span class="badge badge-danger">注意</span></h6>
      <h6 class="card-subjtitle text-muted">有打卡不完整记录</span></h3>
      <p class="card-text mb-3" style="">{{$forgotten->in}} 打卡上班后，忘记打下班卡,请遵循如下步骤.</p>
      <ol>
        <li>打卡下班</li>
         <li>填表补充实际下班时间</li>
          <li>通知店长人工审核</li>
          <li>再次打卡上班</li>
      </ol>
    </div>
  </div>


  
  @endif
  
  
  <hr class="my-4">
  @if(isset($message))
  <p>{{$message}}</p>
  @endif

  @if(count($shifts))
  <h4>今日排班</h4>
  	<table class="table">
  	<thead>
  	<tr class="table-info"><th>Scheduled In</th><th>Scheduled Out</th><th>时长</th><th>工位</th></tr>
  	</thead>
  	<tbody>
  	@foreach($shifts as $s)
  	<tr>
  	<td>{{$s->start->toTimeString()}}</td>
  	<td>{{$s->end->toTimeString()}}</td>
    <td>{{gmdate('G:i',$s->end->diffInSeconds($s->start))}}</td>
    <td>{{ $s->role->c_name }}</td>
	</tr>
  	@endforeach
  	</tbody>
  	</table>
      <hr class="my-4">
  @else
    <p class="alert alert-warning">今日无排班 No scheduled shifts for today.</p>
  @endif

    @if(count($records))
  <p>打卡记录</p>
    <table class="table">
    <thead>
    <tr><th>上班时间</th><th>下班时间</th><th>工时</th></tr>
    </thead>
    <tbody>
    @foreach($records as $r)
    <tr>

    <td>{{$r->clockIn->toTimeString()}}</td>
    @if(isset($r->clockOut))
      <td> 
      {{$r->clockOut->toTimeString()}}
      </td>
      <td> 
      {{  gmdate('G:i:s',$r->clockIn->diffInSeconds($r->out))  }}
      </td>
      @endif
      
  </tr>
    @endforeach
    </tbody>
    </table>
    @else
  @endif

  <p class="lead">
    <a class="btn btn-primary btn-lg" href="/timeclock/" role="button">返回</a>
  </p>
</div>

</div>
</div>
@section('end')