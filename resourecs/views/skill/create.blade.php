@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--mobile col-sm-12 col-md-10 col-lg-6">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Create new skill
				</h3>
			</div>
		</div>
	
	</div>
	<!--begin::Form-->
			<form class="m-form" method="POST" action="{{url('skills/create')}}">
				{{csrf_field()}}
				<div class="m-portlet__body" >

					<div class="m-form__section m-form__section--first">

						<div class="form-group m-form__group">
							<label>Leave Type</label>
{{Form::text('name',['class'=>'form-control m-input'])}}
							
						</div>			
						<div class="form-group m-form__group">
							<label>Date Range</label>
							
								
								<input type="text" name="daterange" id="daterange" class="form-control m-input" placeholder="Pick dates">
						
						</div>			
						<div class="m-form__group form-group">
							<label for="">Comments</label>
							<textarea class="form-control m-input" rows="3" name="comment"></textarea>
		                </div>
		            </div>

	            </div>
	            <div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-secondary">Cancel</button>
					</div>
				</div>
			</form>
			<!--end::Form-->
</div>		        

@endsection
