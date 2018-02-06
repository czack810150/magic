@extends('layouts.master')
@section('content')

@include('exam.question.nav')


<!--Begin::Main Portlet-->
<div class="m-portlet">
  <div class="m-portlet__body m-portlet__body--no-padding">
    <div class="row m-row--no-padding m-row--col-separator-xl">
      <div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-1 -->
<div class="m-widget1">
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Total Questions</h3>
				<span class="m-widget1__desc">题库总量</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-brand">{{ $stats['total'] }}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Multiple Choice</h3>
				<span class="m-widget1__desc">选择题</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-danger">{{ $stats['mc'] }}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Short Answer</h3>
				<span class="m-widget1__desc">简答题</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-success">{{ $stats['sa'] }}</span>
			</div>
		</div>
	</div>
</div>
<!--end:: Widgets/Stats2-1 -->      
		</div>
      <div class="col-md-12 col-lg-12 col-xl-4">

<!--begin::Section-->
				<div class="m-section">
					
					<div class="m-section__content">
						<table class="table table-sm m-table m-table--head-bg-brand">
						  	<thead class="thead-inverse">
						    	<tr>
						      		<th>Category</th>
						      		<th>Questions</th>
						      		
						    	</tr>
						  	</thead>
						  	<tbody>
						  		@foreach($stats['categories'] as $key => $val)

						    	<tr>
							      	<th scope="row">	{{ $key }}</th>
							    
							      	<td>{{$val}}</td>
							      
						    	</tr>

				



	@endforeach
						    
						  	</tbody>
						</table>
					</div>
				</div>
				<!--end::Section-->
       </div>
    </div>
  </div>
</div>
<!--End::Main Portlet-->

@if(isset($questions))

<table class="table table-sm">
	<thead><tr><th>id</th><th>Category</th><th>Question</th><th>difficulty</th><th>created by</th><th>created at</th><th>delete</th></tr></thead>
	<tbody>
	@foreach($questions as $q)
	<tr>
		<td><a href="/question/{{ $q->id }}/show">{{ $q->id }}</a></td>
		
		@if($q->question_category)
		<td><a href="/question_category/{{$q->question_category_id}}">{{ $q->question_category->name}}</a></td>
		@else
		<td></td>
		@endif
		<td><a href="/question/{{ $q->id }}/show">{{ $q->body }}</a> ({{ $q->mc?'选择题':'简答题' }})</td>
		<td>{{ $q->difficulty }}</td>
		<td>{{ $q->created_by }}</td>
		<td>{{ $q->created_at }}</td>
		<td><a href="/question/{{$q->id}}/delete">delete</a></td>

	</tr>
	@endforeach
	</tbody>
</table>
@endif

@endsection