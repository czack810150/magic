@extends('layouts.master')
@section('content')
<div class="container">
<h1>Tips Edit</h1>

@if($tip)

<h4>{{$tip->location->name}}</h4>
<p>{{ $tip->start }} ~ {{$tip->end}}</p>

<form class="form" method="POST" action="/tips/{{ $tip->id }}/update" id="root">

		<div class="form-group mx-sm-3">
			{{ Form::label('tips','Total Tips',['class'=>'mx-sm-3']) }}
			<input type="text"  name="tips" class="" v-model="totalTips">
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('hours','Tip Hours',['class'=>'mx-sm-3']) }}
			{{ Form::text('hours',$tip->hours,['v-model'=>'tipHours']) }}
		</div>

		<div class="form-group mx-sm-3">
			{{ Form::label('hourlyTip','Hourly Tips',['class'=>'mx-sm-3']) }}
			
			<input type="number" min="0.00" step="0.01" name="hourlyTip" v-bind:value="hourlyTip">
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

@section('pageJS')
<script>
	var app = new Vue({
		el: "#root",
		data: {
			totalTips: {{$tip->tips/100}},
			tipHours: {{$tip->hours}},
			hourlyTips: {{$tip->hourlyTip}},
		},
		computed:{
			hourlyTip(){
				return Math.round(this.totalTips / this.tipHours *100)/100;
			}
		}
	})
</script>
@endsection