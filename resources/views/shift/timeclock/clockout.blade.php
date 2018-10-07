@extends('layouts.timeclock.master')
@section('content')
<div class="container">
<div class="row  scanner justify-content-center" >


<div class="col-xs-12 col-sm-12 col-md-5" id="clockForm">

	<h1 class="centered red-flamingo"><i class="fa fa-sign-out fa-5x" aria-hidden="true"></i></h1>
         
<form method="POST" action="/timeclock/out">
{{csrf_field()}}
  <div class="form-group">
    <label for="employeeCard">请扫描员工卡</label>
    <div class="input-group"><span class="input-group-addon">
    
    <i class="fa fa-barcode"></i></span>
	<input type="password" class="form-control" id="employeeCard" name="employeeCard" placeholder="Scan your employee card here" autofocus="autofocus" autocomplete="off" required>	  
    </div>
   
    <small id="emailHelp" class="form-text text-muted">请确认光标在当前输入项</small>
  </div>
 
  <div style="text-align:center;"><button type="submit" class="btn btn-danger">打卡下班</button>
   <a class="btn btn-secondary" href="/timeclock/" role="button">返回</a></div>
</form>
<br>

@include('layouts.errors')
          
</div>
</div>
</div><!-- END container -->
 @endsection