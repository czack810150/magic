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
					Payroll Details
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedLocation">
						<option value="null" disabled>Select Location</option>
						<option v-for="(name,id) in locations" :value="id" v-text="name"></option>
					</select>										
				</li>
				<li class="m-portlet__nav-item">
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedYear" @change="changeYear">
						<option value="null" disabled>Select year</option>
						<option v-for="year in years" :value="year" v-text="year"></option>
					</select>											
				</li>
				
				<li class="m-portlet__nav-item">
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedPeriod">
						<option value="null" disabled>Select period</option>
						<option v-for="(period,start) in dates" :value="start" v-text="period"></option>
					</select>

				</li>
				<li class="m-portlet__nav-item">
				
						<button type="button" class="btn btn-primary" :class="{ disabled: !canView}" @click="viewPayroll">View</button>
				
				</li>
				<li class="m-portlet__nav-item">
				
						{{ Form::button('Download CSV',['class'=>'btn btn-warning','onclick'=>'exportTableToCSV("payroll.csv")']) }}
				
				</li>
			</ul>
		</div>
	</div>
	<div class="m-portlet__body">

	
		<main id="dataTable">
			@{{ selectedLocation }}
		</main>
	</div>
</div>
<!--end::Portlet-->

<script>
    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

let payroll = new Vue({
	el:'#payroll',
	data:{
		selectedYear: new Date().getFullYear(),
		selectedPeriod: null,
		selectedLocation:null,
		years:@json($yearOptions),
		dates:@json($dates),
		locations:@json($locationOptions),
		
	},
	computed:{
		canView(){
			if(this.selectedLocation == null || this.selectedPeriod == null){
				return false;
			}
			return true;
		}
	},
	methods:{
		changeYear(){
			axios.post('/payroll/periods',{
				year: this.selectedYear,
			}).then(res => {
				console.log(res.data);
				this.dates = res.data;
				this.selectedPeriod = null;
			}).catch(e => {
				alert(e);
				console.log(e);
			});

		},
		viewPayroll(){
			if(this.canView){
				axios.post('/payroll/fetch',
					{
						location: this.selectedLocation,
						startDate: this.selectedPeriod,
					}).then( res => {
						$("#dataTable").html(res.data);
					})
			}
			
		},
	}
});
	
</script>
@endsection