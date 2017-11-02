@extends('layouts.master')
@section('content')
<div class="container">
<h1>Employees</h1>

@foreach($employees as $e)
<p>{{$e}}</p>
@endforeach




</div>



@endsection