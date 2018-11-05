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
													Exam Templates
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
											
											</ul>
										</div>
									</div>
					
    <!--begin:: Widgets/Finance Summary-->
	<div class="m-portlet__body">
		<div class="m-widget12">
			
			<div class="m-widget12__item">					 	 
				<span class="m-widget12__text1">Exam Templates<br><span>{{  $templates->count() }}</span></span> 			 		 
						 	 
			</div>
			
		</div>

		@if(count($templates))
<div class="row">
<div class="col-12">
<table class="table table-bordered">
<tr><th>Name</th><th>Action</th><th>Used</th><th>Questions</th><th>Created by</th><th>Date created</th></tr>
@foreach($templates as $t)
<tr>
	
	<td><a href="{{url("/exam_templates/$t->id/show")}}">{{$t->name}}</a></td>
	<td><button type="button" class="btn btn-sm btn-success" onclick="createFromTemplate({{$t->id}},'{{$t->name}}')">New Exam</button></td>
	<td>{{$t->used}}</td>
	<td>{{$t->question->count()}}</td>
	<td>{{$t->employee?$t->employee->cName:'no info'}}</td>
	<td>{{$t->created_at->toFormattedDateString()}}</td>
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



<!-- Modal -->
<div class="modal fade" id="create-exam" tabindex="-1" role="dialog" aria-labelledby="create-examLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create-examLabel"> Create Exam from template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right" method="POST" action="/exam_templates/store">
				@csrf
      <div class="modal-body">	

			
			
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<label for="locationFilter" class="col-4 col-form-label">Location</label>
						<div class="col-8">
							{{ Form::select('locationFilter',$locations,Auth::user()->authorization->location_id,['class'=>'custom-select','id'=>'locationFilter'])}}
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="selectedEmployee" class="col-4 col-form-label">Employee</label>
						<div class="col-8" id="employeeList">
							{{ Form::select('selectedEmployee',$employees,null,['class'=>'custom-select','id'=>'selectedEmployee'])}}
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="examName" class="col-4 col-form-label">Exam Name</label>
						<div class="col-8">
							<input type="text" name="examName" id="examName" value="">
						</div>
					</div>
					<input type="text" name="templateId" id="templateId" value="" hidden>
				</div>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Create Exam</button>
      </div>
      </form>
    </div>
  </div>
</div>


@endsection

@section('pageJS')
<script src="{{URL::asset('js/magic.js')}}"></script>
<script>
	var locationFilter = document.getElementById('locationFilter');
	locationFilter.addEventListener('change',function(){
		locationEmployees();
	},false);	

	function createFromTemplate(id,name)
	{
		$('#examName').val(name);
		$('#templateId').val(id);
		$('#create-exam').modal('show');
	}


</script>
@endsection
