@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet m-portlet--full-height ">
						
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-clipboard"></i>
												</span>
												<h3 class="m-portlet__head-text">
													View All Exams
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
										<a href="/exam/all" class="btn btn-secondary">All exams</a>
												</li>
										
												<li class="m-portlet__nav-item">
													<a href="/exam/attemptedExams" class="btn btn-secondary">Attempted exams</a>
												</li>
												<li class="m-portlet__nav-item">
												<a href="/exam/create" class="btn btn-success">Create new exam</a>
														
												
												</li>
												<li class="m-portlet__nav-item">
												<a href="/exam" class="btn btn-secondary">Back</a>
												
												</li>
											</ul>
										</div>
									</div>
					

<div class="m-portlet__body">
@if(isset($exams))

<table class="table table-sm table-hover">
	<thead><tr><th>id</th><th>Name</th><th>Employee</th><th>Score</th><th>Taken at</th><th>Questions</th><th>Access Code</th><th>created by</th><th>created at</th><th>updated at</th><th>delete</th></tr></thead>
	<tbody>
	@foreach($exams as $e)
	<tr>
		<td><a href="/exam/{{ $e->id }}/show">{{ $e->id }}</a></td>
		<td><a href="/exam/{{ $e->id }}/show">{{ $e->name }}</a></td>
		<td><a href="/employee/{{ $e->employee->id }}/show">{{ $e->employee->cName }}</a></td>
		<td>{{ $e->score }}</td>
		<td>{{ $e->taken_at }}</td>
		<td>{{ count($e->question) }}</td>
		<td>{{$e->access}}</td>
		<td>creator</td>
		<td>{{ $e->created_at }}</td>
		<td>{{ $e->created_at }}</td>
		<td><a class="btn btn-danger btn-sm" href="/exam/{{$e->id}}/delete">delete</a></td>

	</tr>
	@endforeach
	</tbody>
</table>
@else
<div class="m-alert m-alert--icon m-alert--outline alert alert-info alert-dismissible fade show" role="alert">
<div class="m-alert__icon"><i class="la la-warning"></i></div>
<div class="m-alert__text">
<strong>No exams!</strong> You can create one by clicking "Create new exam" button.		
</div>									  	
</div>
@endif				 

</div>
</div>
<!--end::Portlet-->
@endsection