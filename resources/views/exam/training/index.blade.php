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
													知识强化培训
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												
												<li class="m-portlet__nav-item">
												<a href="/exam/learn/create" class="btn btn-success">创建模拟测试</a>
												</li>
												
											</ul>
										</div>
									</div>
					
    <!--begin:: Widgets/Finance Summary-->
	<div class="m-portlet__body">
		<div class="m-widget12">
			<div class="m-widget12__item">					 	 
				<span class="m-widget12__text1">Total Mock Tests<br><span>{{$exams->count()}}</span></span> 			 		 
				<span class="m-widget12__text2">Total Attempted Exams<br><span></span></span> 		 	 
			</div>
			<div class="m-widget12__item">					 	 
				<span class="m-widget12__text1">Exam Templates<br><span></span></span> 			 		 
				<span class="m-widget12__text2">Total Questions<br><span></span></span> 		 	 
			</div>
			<div class="m-widget12__item">
				<span class="m-widget12__text1">Multiple Choice Questions<br><span></span></span>

				<span class="m-widget12__text2">Short Answer Questions<br><span></span></span> 	
			</div>
		</div>
	<br>
	@if(count($exams))
	<table class="table table-sm">
	<thead>
	<tr><th>名称</th><th>创建人</th><th>题数</th><th>创建日期</th><th>操作</th></tr>
	</thead>
	<tbody>
	@foreach($exams as $e)
	<tr>
	<td>{{$e->name}}</td>
	<td>{{$e->employee->name}}</td>
	<td>{{$e->question->count()}}</td>
	<td>{{$e->created_at}}</td>
	<th><a class="btn btn-primary btn-sm" href="{{url("exam/learn/$e->id/mock")}}">开始练习</a></th>
	</tr>
	@endforeach
	</tbody>
	</table>	
	@endif




</div>
<!--end:: Widgets/Finance Summary--> 
</div>
<!--end::Portlet-->
@endsection