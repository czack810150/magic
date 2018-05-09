@extends('layouts.master')
@section('content')

<div class="m-portlet m-portlet--full-height" id="vm">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					Create Taskforce Team <small>创建专项团队</small> 
				</h3>
			</div>
		</div>
        @can('create-team')
        <div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
                    <a href="{{url('team/taskforce')}}" class="btn btn-info">返回</a>
				</li>
			</ul>
		</div>
        @endcan
      
		
	</div>
	<!--begin::Form-->
    <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="{{url('team/taskforce/create')}}">
    {{csrf_field()}}
				<div class="m-portlet__body">
					
					<div class="form-group m-form__group col-md-6 col-sm-12">
						<label for="name">Name</label>
						<input type="text" class="form-control m-input" name="name" aria-describedby="teamName" placeholder="团队名称" required>
						
					</div>
					<div class="form-group m-form__group col-md-6 col-sm-12">
						<label for="leader">Leader</label>
{{Form::select('location',$locations,Auth::user()->authorization->location_id,['class'=>'form-control m-input','v-model'=>'selectedLocation','@change'=>'changeLocation','placeholder'=>'Leader from location'])}}
<br>
<div v-if="showEmployee" id="staffs">
<select name="leader" class="form-control m-input" required>
<option v-for="employee in employees" v-bind:value="employee.id">@{{employee.name}}</option>
</select>
</div>
						
					</div>
					<div class="form-group m-form__group col-md-6 col-sm-12">
						<label>Superior</label>
{{Form::select('superior',$teams,null,['class'=>'form-control m-input','placeholder'=>'Choose superior team'])}}
<span class="m-form__help">上级管理团队</span>		
					</div>
				
					
					<div class="form-group m-form__group">
						<label for="description">Description</label>
						<textarea class="form-control m-input" name="description" rows="3"></textarea>
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-secondary">Cancel</button>
					</div>
				</div>
			</form>
			<!--end::Form-->	
</div>
		
		
<script>
var vm = new Vue({
    el: '#vm',
    data: {
        selectedLocation:'',
        showEmployee:false,
        employees: [
            
        ],
        token: '{{csrf_token()}}',
    },
    methods: {
        changeLocation: function(){
            $.post(
                '{{url('employeeByLocation')}}',
                {
                    _token: this.token,
                    location: this.selectedLocation,
                },
                function(data,status){
                    if(status == 'success'){
                        vm.employees = data
                        vm.showEmployee = true;
                    } else {
                        console.log('fail')
                    }
                }
            )
        }
    }
})
</script>
@endsection