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
													{{$template->name}}
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item">
										<a href="/exam_templates" class="btn btn-secondary">Back</a>
												</li>
												<li class="m-portlet__nav-item">
										<a href="/exam_templates/{{$template->id}}/remove" class="btn btn-danger">Remove</a>
												</li>
										
												
											</ul>
										</div>
									</div>
					
    <!--begin:: Widgets/Finance Summary-->
	<div class="m-portlet__body">
		

@if($template)
<div class="row">
<div class="col-12">

<table class="table table-bordered">
<tr><th>Category</th><th>Question</th><th>Type</th><th>Level</th></tr>
@foreach($template->question as $q)
<tr>
	<td>{{$q->question->question_category->name}}</td>
	<td>{{$q->question->body}}</td>
	<td>{{$q->question->mc?'选择':'简答'}}</td>
	<td>{{$q->question->difficulty}}</td>
</tr>
@endforeach
</table>



</div>
</div>
@endif			 

</div>
<!--end:: Widgets/Finance Summary--> 
</div>
<!--end::Portlet-->
@endsection