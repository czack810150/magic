@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-md-6">
		<!--begin::Portlet-->
		<div class="m-portlet m-portlet--tab">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Add a new user	
						</h3>
					</div>
				</div>
			</div>
			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right" method="POST" action="/users/save" >
				{{ csrf_field() }}
				<div class="m-portlet__body">
					<div class="form-group m-form__group m--margin-top-10">
						<div class="alert m-alert m-alert--default" role="alert">
							Becareful of what you are playing with.
						</div>
					</div>
					<div class="form-group m-form__group">
						<label for="username">User name</label>
						<input type="text" class="form-control m-input" id="username" name="username" aria-describedby="emailHelp" placeholder="User name" required>
						<span class="m-form__help">We'll never share this email with anyone else.</span>
					</div>
					<div class="form-group m-form__group">
						<label for="email">Email address</label>
						<input type="email" class="form-control m-input" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
						<span class="m-form__help">We'll never share this email with anyone else.</span>
					</div>
					<div class="form-group m-form__group">
						<label for="password">Password</label>
						<input type="password" class="form-control m-input" id="password" name="password" placeholder="Password" required>
					</div>
					<div class="form-group m-form__group">
						<label for="password_confirmation">Confirm password</label>
						<input type="password" class="form-control m-input" id="password_confirmation" name="password_confirmation" placeholder="Password confirmation" required>
					</div>
					<div class="form-group m-form__group">
						<label for="typeSelect">Choose user authorization</label>
						{{ Form::select('typeSelect',$types,null,['class'=>'form-control m-input','id'=>'typeSelect','placeholder'=>'select user type']) }}
					</div>
					<div class="form-group m-form__group">
						<label for="locationSelect">Select a location</label>
						{{ Form::select('locationSelect',$locations,9,['class'=>'form-control m-input','id'=>'locationSelect','onchange'=>'locationChange(this.value)']) }}
					</div>

					<div class="form-group m-form__group" id="employeeList">
					</div>
					
				
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-secondary">Cancel</button>
					</div>
					@include('layouts.errors')

				</div>
			</form>
			<!--end::Form-->	
		

		</div>
		<!--end::Portlet-->
	</div>
</div>

<script>
	function locationChange(value){
		if($('#typeSelect').val() != 'location' ){
		$.post(
			'/api/employeeBylocation',
			{
				location: value,
			},
			function(data,status){
				if(status == 'success'){
					var html = '<label for="employee">Associate employee</label>';
					 html +='<select class="form-control m-input" name="employee" id="employee">';
					for(var i in data){
						
						console.log(data[i]);
						html += '<option value="'+ i +'">'+ data[i] + '</option>'
						}
						html += '</select>';
						$('#employeeList').html(html);
					
					
				}
			},
				'json'
			);
		}
	}
</script>


@endsection

@section('pageJS')

@endsection