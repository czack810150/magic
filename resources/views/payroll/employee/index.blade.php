@extends('layouts.master')
@section('content')

<!--begin::Portlet-->
<div class="m-portlet" id="payroll">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="flaticon-coins"></i>
				</span>
				<h3 class="m-portlet__head-text">
					Employee year summary
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<form method="post" :action="endpoint">
				@csrf
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedLocation" @change="getEmployees">
						<option value="null" disabled>Select Location</option>
						<option v-for="(name,id) in locations" :value="id" v-text="name"></option>
					</select>										
				</li>
				<li class="m-portlet__nav-item">
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedYear" name="year">
						<option value="null" disabled>Select year</option>
						<option v-for="year in years" :value="year" v-text="year"></option>
					</select>											
				</li>
				<li class="m-portlet__nav-item">
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedEmployee" name="employee">
						<option value="null" disabled>Select staff</option>
						<option v-for="employee in employees" :value="employee.id" v-text="employee.name"></option>
					</select>											
				</li>
				
				
				<li class="m-portlet__nav-item">
				
						<button type="submit" class="btn btn-primary" :class="{ disabled: !canView}" >View</button>
				
				</li>
				
			</ul>
			</form>
		</div>
	</div>

</div>
<!--end::Portlet-->


<script>

let payrollYear = new Vue({
	el:'#payroll',
	data:{
		selectedYear: new Date().getFullYear(),
		selectedLocation:null,
		selectedEmployee:null,
		years:@json($yearOptions),
	
		locations:@json($locationOptions),
		employees:[],
		endpoint:'/payroll/employee/year',

		
	},
	computed:{
		canView(){
			if(this.selectedLocation == null || this.selectedEmployee == null){
				return false;
			}
			return true;
		}
	},
	methods:{
		getEmployees(){
			console.log(this.selectedLocation);
			
			axios.post('/employee/location',{
				location:this.selectedLocation
			}).then(res => {
				this.employees = res.data;
			}).catch(e => {
				alert(e);
				console.log(e);
			});
		}
	}
});
	
</script>



@endsection