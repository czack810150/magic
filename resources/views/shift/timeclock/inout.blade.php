@extends('layouts.timeclock.master')

@section('content')


<div class="container-fluid">
<div class="row">
<div class="col in">
<a class="btn btn-primary action-tag" href="/timeclock/in">
<div class="action-button">
<h1>IN</h1>
<h1>上班</h1>
</div>
</a>
</div>

<div class="col out">
<a class="btn btn-danger action-tag" href="/timeclock/out">

<div class="action-button">
<h1>OUT</h1>
<h1>下班</h1>
</div>
</a>

</div>
</div>

@endsection