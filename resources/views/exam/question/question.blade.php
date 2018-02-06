@extends('layouts.master')
@section('content')

@include('exam.question.nav')

@if(isset($question))



<div class="row">
	<div class="col-lg-10 col-md-10 col-12">
		<!--begin::Portlet-->
		<div class="m-portlet m-portlet--info m-portlet--head-solid-bg m-portlet--rounded">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-questions-circular-button"></i>
						</span>
						<h3 class="m-portlet__head-text">
							{{$question->body}}
						</h3>
					</div>			
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<a href="/question/{{ $question->id }}/edit" class="m-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air">
								Edit
							</a>
						</li>
						
					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
				<h5>类别：{{ $question->question_category->name }} </h5>
				<h5>难度：<span class="m-badge m-badge--warning">{{ $question->difficulty }}</span> </h5>
				<br>
				@if(count($question->answer))

<ul>
	@foreach($question->answer as $answer)
	<li class="mb-2">
	<span
	@if($answer->correct)
	class="alert-success"
	@endif
	>
	{{$answer->answer}}</span> </li>
	@endforeach
</ul>
				@else
					<p>简答题</p>
				@endif
			</div>
		</div>	
		<!--end::Portlet-->
	</div>
</div>






@endif


<a href="/question">Back</a>





@endsection