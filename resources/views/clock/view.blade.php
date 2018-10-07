@extends('layouts.master')
@section('content')
<div class="m-portlet m-portlet--bordered m-portlet--rounded m-portlet--unair" id="root">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">View Employee Clocks</h3>
			</div>
		</div>
	</div>

	<div class="m-portlet__body">
		<div class="row m-row--no-padding m-row--col-separator-xl">
			<div class="col-md-12 col-lg-6 col-xl-3">
				<!--begin::Total Profit-->
				<div class="m-widget24">					 
				    <div class="m-widget24__item">
				        <h4 class="m-widget24__title">
				            Total Hours
				        </h4><br>
				        <span class="m-widget24__desc">
				            打卡记录
				        </span>
				        <span class="m-widget24__stats m--font-brand">
				            @{{ totalHours }} Hours 
				        </span>		
				       
				    </div>				      
				</div>
				<!--end::Total Profit-->
			</div>
		</div>


				<!--begin: Search Form -->
		<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
			<div class="row align-items-center">
				<div class="col-xl-8 order-2 order-xl-1">
					<div class="form-group m-form__group row align-items-center">
						<div class="col-md-4">
							<div class="m-form__group m-form__group--inline">
								<div class="m-form__label">
									<label for="location">Location</label>
								</div>
								<div class="m-form__control">
<select class="custom-select" v-model="selectedLocation" v-on:change="changeLocation">
	<option disabled value="">Please select one</option>
	<option v-for="location in locations" v-text="location.name" v-bind:value="location.key"></option>
</select>
								</div>
							</div>
						</div>
<div class="col-md-4">
							<div class="m-form__group m-form__group--inline">
								<div class="m-form__label">
									<label for="employee">Employee</label>
								</div>
								<div class="m-form__control">
<select class="custom-select" v-model="selectedEmployee" v-on:change="changeEmployee">
	<option  value="all">All</option>
	<option v-for="employee in employees" v-text="employee.name" v-bind:value="employee.id"></option>
</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="m-form__group m-form__group--inline">
								<div class="m-form__label">
									<label class="m-label m-label--single">Date range</label>
								</div>
								<div class="m-form__control">
<input type="text" class="form-control m-input m-input--solid" placeholder="Pick a date range.." id="dateRangePicker">
			
								</div>
							</div>
							<div class="d-md-none m--margin-bottom-10"></div>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
		<!--end: Search Form -->
		<section id="clockTable" v-if="clocks.length">
			<table class="table">
				<thead>
				<tr><th>Location</th><th v-if="selectedEmployee == 'all'">Employee</th><th>ClockIn</th><th>ClockOut></th><th>Comment</th></tr>
			</thead>
			<tbody>
				<tr v-for="clock in clocks">
					<td>@{{clock.location.name}}</td>
					<td v-if="selectedEmployee == 'all'">@{{clock.employee.name}}</td>
					<td>@{{clock.clockIn}}</td>
					<td>@{{clock.clockOut}}</td>
					<td>@{{clock.comment}}</td>
				</tr>
			</tbody>
			</table>
		</section>			
	</div>
</div>





@endsection

@section('pageJS')

<script>

 
var app = new Vue({
	el:'#root',
	data:{
		token:'{{csrf_token()}}',
		locations: [
		@foreach($locations as $key => $location)
			{ key:{{$key}},name:"{{$location}}" },
		@endforeach
		],
		selectedLocation:'{{$defaultLocation}}',
		employees : [
		
		@foreach($employees as $employee)
			{ id:{{$employee->id}},name:"{{$employee->name}}" },
		@endforeach
		
		],
		selectedEmployee:'all',
		startDate: '',
		endDate : '',
		clocks: [],

	},
	computed:{
		totalHours(){
			if(this.clocks.length){
				var total = 0;
				for(var i in this.clocks){
					if(this.clocks[i].clockIn != null && this.clocks[i].clockOut != null){
						total += (moment(this.clocks[i].clockOut).unix() - moment(this.clocks[i].clockIn).unix())/3600;
					}
				}
				return total.toFixed(2);
			} else {
				return 0;
			}
		}
	},
	methods:{
		changeLocation: function(){
			axios.post('{{url('employeeByLocation')}}',{
				_token: this.token,
				location: this.selectedLocation
			}).then(function(response){
				app.employees = response.data
				selectedEmployee = app.employees[0].id
			}).catch(function(error){
				console.log(error)
			})
		},
		changeEmployee(){
			this.getClocks();
		},
		getClocks(){
			axios.post('{{'employeeClocksByDateRange'}}',{
				_token: this.token,
				employee: this.selectedEmployee,
				startDate:this.startDate,
				endDate:this.endDate,
				location:this.selectedLocation
			}).then(function(response){
				
				app.clocks = response.data;
			})
		}
	},
	mounted: function(){

$('#dateRangePicker').daterangepicker({
	startDate: moment().subtract(7,'days').format('YYYY-MM-DD'),
	locale: {
		format:'YYYY-MM-DD'
	}
});
$('#dateRangePicker').on('apply.daterangepicker',function(ev,picker){
	
	app.startDate = picker.startDate.format('YYYY-MM-DD');
	app.endDate = picker.endDate.format('YYYY-MM-DD');
	if(app.selectedEmployee != ''){
		app.getClocks();
	}
});
var drp = $('#dateRangePicker').data('daterangepicker');
this.startDate = drp.startDate.format('YYYY-MM-DD');
this.endDate = drp.endDate.format('YYYY-MM-DD');
	}
});

</script>


@endsection