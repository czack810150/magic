@extends('layouts.master')
@section('content')
<div class="container">
<h1>Tips Edit</h1>

@if($tip)

<h4>{{$tip->location->name}}</h4>
<p>{{ $tip->start }} ~ {{$tip->end}}</p>

<form class="form" method="POST" action="/tips/{{ $tip->id }}/update">

		<div class="form-group mx-sm-3">
			{{ Form::label('tips','Total Tips',['class'=>'mx-sm-3']) }}
			{{ Form::text('tips',$tip->tips*100) }}
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('hours','Tippable Hours',['class'=>'mx-sm-3']) }}
			{{ Form::text('hours',$tip->hours) }}
		</div>

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