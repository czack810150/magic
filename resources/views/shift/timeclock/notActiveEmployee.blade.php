@extends('layouts.timeclock.master')
@section('content')

<div class="container">
<div class="row  scanner justify-content-center" >

<div class="jumbotron">
  <h1 class="display-3">员工 {{$employee->cName}}</h1>
  
  @if($employee->status == 'vacation')
  <p class="lead">处于<span class="badge badge-warning">休假状态</span>，不能上班。</p>
  <p class="lead">is on vacation, ineligible to clock in for work.</p>
  @endif

  @if($employee->termination)
  <p class="lead">已于 {{$employee->termination}} 离职。 如需要继续工作请重新申请加入。</p>
    <p class="lead">has terminated employment status on {{$employee->termination}}. You may re-apply for work.</p>
  @endif
 
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="/timeclock/" role="button">返回</a>
  </p>
</div>

</div>
</div>
@section('end')