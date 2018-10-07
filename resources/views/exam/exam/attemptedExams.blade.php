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
													Attempted Exams
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
<div class="row">
	
@if(isset($exams))
<div class="col-lg-10 col-md-12 col-sm-12">
<table class="table table-sm table-striped" >
	<thead><tr><th>考试名称</th><th>员工</th><th>正确率</th><th>选择题得分</th><th>选择题数</th><th>简答题数</th><th>考试题数</th><th>Taken at</th></tr></thead>
	<tbody>
	@foreach($exams as $e)
	<tr>
		
		<td><a href="/exam/{{ $e->id }}/mark">{{ $e->name }}</a></td>
		<td><a href="/staff/profile/{{ $e->employee->id }}/show">{{ $e->employee->cName }}</a></td>
		<td><span class="">{{ $e->score?round($e->score / $e->mc,2)*100 :'' }}%</span></td>
		<td>{{ $e->score }} </td>
		<td>{{ $e->mc }}</td>
		<td>{{ count($e->question) - $e->mc }}</td>
		<td>{{ count($e->question) }}</td>
		<td>{{ $e->taken_at }}</td>
		
		
	</tr>
	@endforeach
	</tbody>
</table>
</div>
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
</div>
<!--end::Portlet-->
@endsection
