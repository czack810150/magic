@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--mobile col-sm-12 col-md-10 col-lg-6">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Edit skill
				</h3>
			</div>
		</div>
	
	</div>
	<!--begin::Form-->
			<form class="m-form" method="POST" action="{{url("skills/$skill->id/update")}}">
				{{csrf_field()}}
				<div class="m-portlet__body" >

					<div class="m-form__section m-form__section--first">

						<div class="form-group m-form__group">
							<label>Category</label>
{{Form::select('category',$categories,$skill->skill_category_id,['class'=>'form-control m-input'])}}
							
						</div>

						<div class="form-group m-form__group">
							<label>Skill English Name</label>
{{Form::text('name',$skill->name,['class'=>'form-control m-input'])}}
							
						</div>			
						<div class="form-group m-form__group">
							<label>中文名称</label>
							
								
{{Form::text('cName',$skill->cName,['class'=>'form-control m-input'])}}
						
						</div>			
						<div class="m-form__group form-group">
							<label for="">Description</label>
							<textarea class="form-control m-input" rows="3" name="description" >{{$skill->description}}</textarea>
		                </div>
		            </div>

	            </div>
	            <div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<button type="submit" class="btn btn-primary">Update</button>
						<button type="reset" class="btn btn-secondary">Cancel</button>
					</div>
				</div>
			</form>
			<!--end::Form-->
</div>		        

@endsection
