@extends('layouts.master')
@section('content')


<!--begin::Portlet-->
<div class="m-portlet" id="performance">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="flaticon-users"></i>
				</span>
				<h3 class="m-portlet__head-text">
					Employee Scores
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">

				<li class="m-portlet__nav-item">

					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedLocation" >
						<option value="null" disabled>Select Location</option>
						<option v-for="(name,id) in locations" :value="id" v-text="name"></option>
					</select>
				</li>

				<li class="m-portlet__nav-item">
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedYear" @change="changeYear" name="year">
						<option value="null" disabled>Select year</option>
						<option v-for="year in years" :value="year" v-text="year"></option>
					</select>

				</li>

		<li class="m-portlet__nav-item">	
			
		
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedPeriod" @change="locationEmployees">
						<option value="null" disabled>Select period</option>
						<option v-for="(period,start) in dates" :value="start" v-text="period"></option>
					</select>

		

		</li>

				<li class="m-portlet__nav-item">
					<button type="button"  @click="locationEmployees" class="m-portlet__nav-link m-portlet__nav-link--icon">
						<i class="la la-refresh"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="m-portlet__body">
		<main id="employees"></main>
	</div>
</div>
<!--end::Portlet-->


@endsection
@section('pageJS')
<script>
let app = new Vue({
	el:'#performance',
	data:{
		selectedYear:new Date().getFullYear(),
			selectedPeriod:null,
			selectedLocation:null,
			years:@json($yearOptions),
			dates:@json($dates),
			locations:@json($locationOptions),
			
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
		locationEmployees()
		{
			if(this.selectedPeriod != null && this.selectedLocation != null){
				axios.post('/employee/reviewable',{
				period:this.selectedPeriod,
				location:this.selectedLocation
				}).then( res => {
					$("#employees").html(res.data);	
				}).catch(e => {
					console.log(e);
					alert(e);
				});
			} else {
				alert('You must provide both period and location.');
			}
			
		}
	},
})



//var list = $('#location');
    let transition = '<div class="row"><div class="col-md-4 offset-md-5"><h1><i class="fa fa-spinner fa-pulse fa-3x"></i></h1></div></div>';

//list.on('change',locationEmployees());
	function locationEmployees(){
		if($("#location").val() == '' ){
			alert('You must choose a location.');
		} else{
			$("#employees").html(transition);
			$.post(
				'/employee/reviewable',
				{
					period: $("#period").val(),
					location: $("#location").val(),
					_token: '{{ csrf_token() }}'
				},
				function(data,status){                    
					if(status == 'success'){
						$("#employees").html(data);	
					}
				}
				);
		}
		
	}

</script>


@endsection