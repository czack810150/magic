@extends('layouts.timeclock.master')
@section('content')

<div class="container">
<div class="row  scanner justify-content-center" >

<div class="jumbotron">
	
	
	<h1 class="display-5 alert alert-info">无
		<span class="badge badge-warning">
		{{ $employee->cName }}
		</span>
	的上班记录</h1>

  
  
  <hr class="my-4">
  

  <p class="lead">
    <a class="btn btn-primary btn-lg" href="/timeclock/" role="button">返回</a>
  </p>
</div>

</div>
</div>
@section('end')