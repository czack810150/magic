@extends('layouts.master')
@section('content')
<div class="container">
<h1>Tips Edit</h1>

@if($tip)

<h4>{{$tip->location->name}}</h4>
<p>{{ $tip->start }} ~ {{$tip->end}}</p>

<form class="form-inline" method="POST" action="/tips/{{ $tip->id }}/update">

	

		<div class="form-group mx-sm-3">
			{{ Form::label('hourlyTip','Hourly Tips',['class'=>'mx-sm-3']) }}
			{{ Form::number('hourlyTip',$tip->hourlyTip,['min'=>'0.00','step' => '0.01']) }}
		</div>


		{{ Form::submit('Update',['class'=>'btn btn-primary']) }}
		{{csrf_field()}}


</form>

@endif


<div class="input-group">
<a href="/tips/">Back</a>
</div>
</div>
@endsection