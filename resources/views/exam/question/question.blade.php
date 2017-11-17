@extends('layouts.master')
@section('content')
<div class="container">
<h1>Question</h1>

@if(isset($question))

<p>{{$question->body}}</p>

<ul>
	@foreach($question->answer as $answer)
	<li 
	@if($answer->correct)
	class="alert-success"
	@endif
	>
	{{$answer->answer}} </li>
	@endforeach
</ul>

@endif


<a href="/question">Back</a>


</div>



@endsection