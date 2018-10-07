@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet">
						
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-clipboard"></i>
												</span>
												<h3 class="m-portlet__head-text">
													Exam Templates
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
											<li class="m-portlet__nav-item">
										<a href="/exam_templates" class="btn btn-secondary">Templates</a>
												</li>
											</ul>
										</div>
									</div>
					
	<div class="m-portlet__body">
		<div class="m-alert m-alert--icon m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="la la-check"></i>
					</div>
					<div class="m-alert__text">
					  	<strong>Well done!</strong> You successfully created an exam from a template.		
					</div>			  	
		</div>
	</div>
</div>	
<!--end::Portlet-->
@endsection