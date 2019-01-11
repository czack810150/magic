@extends('layouts.master')
@section('content')

<section id="storeHours">
<!--begin::Portlet-->
		<div class="m-portlet">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Location Yearly Hours
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="selectedYear" @change="changeYear" name="year">
								<option value="null" disabled>Select year</option>
								<option v-for="year in years" :value="year" v-text="year"></option>
							</select>
						</li>						
						
					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
				<!--begin::Section-->
				<div class="m-section">
					<div class="m-section__content">

						<table class="table table-bordered m-table">
							<thead>
								<tr><th>Location</th><th>Scheduled</th><th>Effective</th><th>Overtime</th><th>Night</th></tr>
							</thead>
							<tbody>
								<tr v-for="location in locations">
									<td>@{{ location.name }}</td>
									<td>@{{ location.scheduled }}</td>
									<td>@{{ location.effective }}</td>
									<td>@{{ location.overtime }}</td>
									<td>@{{ location.night }}</td>
								</tr>
							</tbody>
						</table>

						
					</div>
				</div>
				<!--end::Section-->
			</div>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
</section>


<script>
	var app = new Vue({
		el: '#storeHours',
		data: {
			selectedYear:new Date().getFullYear(),
			years:@json($yearOptions),
			locations:@json($locationsStats),
		},
		methods: {
			changeYear(){
				axios.post('/hours/store/year',{
					year: this.selectedYear,
				}).then(res => {
					console.log(res.data);
					this.locations = res.data;
					
				}).catch(e => {
					alert(e);
					console.log(e);
				});
			},
			
		},
		
	});


</script>
@endsection