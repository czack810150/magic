@extends('layouts.master')
@section('content')
@include('hour.nav')

 <div class="row" id="compute">
	<div class="col-12">
		<!--begin::Portlet-->
		<div class="m-portlet m-portlet--tab">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Compute Employee Hours 	
						</h3>
					</div>
				</div>
			</div>
			<!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right">
				<div class="m-portlet__body">

					<div class="row justify-content-md-center" v-if="inProgress"><div class="col-md-1"><h1><i class="fa fa-spinner fa-pulse fa"></i></h1></div></div>
					
					
					<div class="form-group m-form__group m--margin-top-10" >
						<div class="alert m-alert m-alert--default" role="alert">
							A place to compute employee scheduled hours, clocked hours, effective hours, overtime hours and night shift hours for a given payroll period.
						</div>
						<p class="alert alert-success" v-if="computeFinish"><strong>计算成功！</strong> @{{ records }} new records have been saved.</p>
					</div>
					
					
				
					<div class="form-group m-form__group row" v-if="!computeFinish">

						<div class="col-3">
							{{ Form::label('forLocation','Location',[])}}
							<select class="custom-select" v-model="selectedLocation"  name="location">
							<option value="null" disabled>Select Location</option>
							<option value="all">All Locations</option>
							<option v-for="(name,id) in locations" :value="id" v-text="name"></option>
							</select>
							<span class="m-form__help">Choose one or all locations</span>
						</div>
						<div class="col-3">
							<label>Year</label>
							<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedYear" @change="changeYear" name="year">
								<option value="null" disabled>Select year</option>
								<option v-for="year in years" :value="year" v-text="year"></option>
							</select>
						</div>


						<div class="col-3">
						{{ Form::label('dateRange','Payroll period',[])}}
						<select class="custom-select" v-model="selectedPeriod" name="dateRange">
						<option value="null" disabled>Select period</option>
						<option v-for="(period,start) in dates" :value="start" v-text="period"></option>
						</select>
						<span class="m-form__help">Please provide the payroll period</span>
						</div>

						
					</div>
				
					
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit" v-if="!computeFinish">
					<div class="m-form__actions">
						<button class="btn btn-danger" type="button" @click="compute">Compute</button>
						
					</div>
				</div>
			</form>
			<!--end::Form-->			
		</div>
		<!--end::Portlet-->
	</div>
</div>


<script>
	let app = new Vue({
		el:'#compute',
		data: {
			selectedYear:new Date().getFullYear(),
			selectedPeriod:null,
			selectedLocation:null,
			years:@json($yearOptions),
			
			dates:@json($dates),
			locations:@json($locationOptions),
			computeFinish: false,
			inProgress:false,
			records:0,
		},
		methods: {
			compute(){
				if(this.selectedLocation == null || this.selectedPeriod == null){
					alert('You must provide location and payroll period');
					return false;
				}
			
				this.inProgress = true;
				axios.post('/hours/compute',{
					startDate: this.selectedPeriod,
					location:this.selectedLocation,
				}).then(res => {
					this.records = res.data;
					this.computeFinish = true;
					this.inProgress = false;
				}).catch(e =>{
					console.log(e);
					alert(e);
				});

			},
			changeYear(){
				axios.post('/payroll/periods',{
					year: this.selectedYear,
				}).then(res => {
					this.dates = res.data;
					this.selectedPeriod = null;
				}).catch(e => {
					alert(e);
					console.log(e);
				});
			},
			
		},
		computed:{
		canView(){
			if(this.selectedLocation == null || this.selectedPeriod == null){
				return false;
			}
			return true;
		}
		},
	});

</script>

@endsection