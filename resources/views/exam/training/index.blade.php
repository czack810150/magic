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
										<a href="/exam/all" class="btn btn-secondary">All exams</a>
												</li>
										
												<li class="m-portlet__nav-item">
													<a href="/exam/attemptedExams" class="btn btn-secondary">Attempted exams</a>
												</li>
												<li class="m-portlet__nav-item">
												<a href="/exam/learn/create" class="btn btn-success">创建模拟测试</a>
														
												
												</li>
												<li class="m-portlet__nav-item">
												
												
												</li>
											</ul>
										</div>
									</div>
					
    <!--begin:: Widgets/Finance Summary-->
	<div class="m-portlet__body">
		<div class="m-widget12">
			<div class="m-widget12__item">					 	 
				<span class="m-widget12__text1">Total Mock Tests<br><span>{{$exams}}</span></span> 			 		 
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



</div>
<!--end:: Widgets/Finance Summary--> 
</div>
<!--end::Portlet-->
@endsection