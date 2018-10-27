@extends('layouts.master')
@section('content')

@include('exam.question.nav')

<div class="row">
	<div class="col-lg-10 col-md-10 col-12">
@if(isset($question))
{{ Form::open(['url' => "question/$question->id/update", 'method' => 'post']) }}
		<!--begin::Portlet-->
		<div class="m-portlet m-portlet--info m-portlet--head-solid-bg m-portlet--rounded">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-questions-circular-button"></i>
						</span>
						<h3 class="m-portlet__head-text">
						
							Edit Question
						</h3>
					</div>			
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							{{ Form::submit('Update',['class' => 'm-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air']) }}
						</li>
						<li class="m-portlet__nav-item">
							<a class="m-portlet__nav-link btn btn-light m-btn m-btn--pill m-btn--air" href="{{ url("/question/$question->id/delete")}}">Delete</a>
						</li>
						
					</ul>
				</div>
			</div>
			<div class="m-portlet__body">


<div class="form-group">
	{{ Form::label('question','Question') }}
	{{ Form::text('question',$question->body,['class' => 'form-control']) }}
	<small id="questionHelp" class="form-text text-muted">问题题目</small>
</div>


@if(count($question->answer))

		<div class="form-group">
			{{ Form::label('correct','Correct Answer') }}
			{{ Form::text('correct',$question->answer[0]->answer,['class' => 'form-control']) }}
			@if($question->answer[0]->correct)
			<small id="questionHelp" class="form-text text-muted">正确答案</small>
			@endif
		</div>

		<div class="form-group">
			{{ Form::label('answer1','Wrong Answer 1') }}
			{{ Form::text('answer1',$question->answer[1]->answer,['class' => 'form-control']) }}
			
		</div>

		<div class="form-group">
			{{ Form::label('answer2','Wrong Answer 2') }}
			{{ Form::text('answer2',$question->answer[2]->answer,['class' => 'form-control']) }}
			
		</div>

		<div class="form-group">
			{{ Form::label('answer3','Wrong Answer 3') }}
			{{ Form::text('answer3',$question->answer[3]->answer,['class' => 'form-control']) }}
			
		</div>

		



@else
	<p>简答题</p>
@endif			

<div class="form-group">
			{{ Form::label('category','Category') }}
			{{ Form::select('category',$categories,$question->question_category_id,['class' => 'form-control']) }}
			
		</div>
		<div class="form-group">
			{{ Form::label('difficulty','Question Difficulty') }}
			{{ Form::number('difficulty',$question->difficulty,['class' => 'form-control','min' => 0,'max' => 9]) }}
			
		</div>

			</div>
		</div>	
		<!--end::Portlet-->

{{ Form::close() }}
@endif
	</div>
</div>



<a href="{{ url()->previous() }}">Back</a>


@endsection