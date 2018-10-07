@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet" id="root">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="flaticon-clock"></i>
				</span>
				<h3 class="m-portlet__head-text">
					Available Hours for Work
				</h3>
			</div>
		</div>
		
	</div>

<!--begin::Form-->
<form class="m-form ">

<div class="m-portlet__body">
<div class="form-group m-form__group m--margin-top-10">
	<div class="alert m-alert m-alert--default" role="alert">
		If you can work ANYTIME for a day, just set the "From" to 00:00:00 and "To" to 24:00:00.
	</div>
</div>

<table class="table">
						<thead>
						<tr><th>Day</th><th style="width:40%">From</th><th style="width:40%">To</th></tr>
					</thead>
					<tbody>
						<tr>
							<th>Monday</th>
							<td>
								<select v-model="availability.mon.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.mon.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Tuesday</th>
							<td>
								<select v-model="availability.tue.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.tue.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
						</tr>
							<tr>
							<th>Wednesday</th>
							<td>
								<select v-model="availability.wed.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.wed.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Thursday</th>
							<td>
								<select v-model="availability.thu.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.thu.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							</tr>
							<tr>
							<th>Friday</th>
							<td>
								<select v-model="availability.fri.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.fri.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<tr>
							<th>Saturday</th>
							<td>
								<select v-model="availability.sat.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.sat.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							</tr>
							<tr>
							<th>Sunday</th>
							<td>
								<select v-model="availability.sun.from" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							<td>
								<select v-model="availability.sun.to" class="form-control m-input">
								<option value="null" disabled>Choose Time</option>
								<option v-for="hour in hours" :value="hour" v-text="hour"></option>
								</select>
							</td>
							</tr>
							<tr>
								
								<th>Hour Limit</th>
								<td >
									@{{availability.hourLimit}} (You can ask your store manager to change this.)
								</td>
							</tr>

							<tr>
								<th>Holiday</th>
								<td v>
									@{{ availability.holiday }} (You can ask your store manager to change this.)
								</td>
							</tr>
						
					</tbody>
					</table>

</div> <!--end::Portlet body-->



<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions">
						<button type="button" class="btn btn-info" @click="submitAvailability">Update my availability</button>
						<button type="button" class="btn btn-secondary" @click="availabilityReset" >Cancel</button>
					</div>
</div>
</form>
<!--end::Form-->
</div>
<!--end::Portlet-->						
@endsection
@section('pageJS')

<script>

var app = new Vue({
	el:'#root',
	data:{
		token:'{{csrf_token()}}',
		currentEmployee:{{Auth::user()->authorization->employee_id}},
		hours:[
			@foreach($hours as $h)
				'{{$h}}',
			@endforeach
		],

		availability:{
			mon:{
				from:'{{is_null($availability->monFrom)?'null':$availability->monFrom}}',
				to:'{{is_null($availability->monTo)?'null':$availability->monTo}}',
			},
			tue:{
				from:'{{is_null($availability->tueFrom)?'null':$availability->tueFrom}}',
				to:'{{is_null($availability->tueTo)?'null':$availability->tueTo}}',
			},
			wed:{
				from:'{{is_null($availability->wedFrom)?'null':$availability->wedFrom}}',
				to:'{{is_null($availability->wedTo)?'null':$availability->wedTo}}',
			},
			thu:{
				from:'{{is_null($availability->thuFrom)?'null':$availability->thuFrom}}',
				to:'{{is_null($availability->thuTo)?'null':$availability->thuTo}}',
			},
			fri:{
				from:'{{is_null($availability->friFrom)?'null':$availability->friFrom}}',
				to:'{{is_null($availability->friTo)?'null':$availability->friTo}}',
			},
			sat:{
				from:'{{is_null($availability->satFrom)?'null':$availability->satFrom}}',
				to:'{{is_null($availability->satTo)?'null':$availability->satTo}}',
			},
			sun:{
				from:'{{is_null($availability->sunFrom)?'null':$availability->sunFrom}}',
				to:'{{is_null($availability->sunTo)?'null':$availability->sunTo}}',
			},
			hourLimit:'{{ empty($availability->hours)?'No information':"I can work up to $availability->hours hours per week" }}',
			holiday:'{{ empty($availability->holiday)? 'I can not work on holidays':'I can work on holidays'}}',
		}
	},
	methods:{
		
		availabilityReset(){
			this.availability = {
			mon:{
				from:'{{is_null($availability->monFrom)?'null':$availability->monFrom}}',
				to:'{{is_null($availability->monTo)?'null':$availability->monTo}}',
			},
			tue:{
				from:'{{is_null($availability->tueFrom)?'null':$availability->tueFrom}}',
				to:'{{is_null($availability->tueTo)?'null':$availability->tueTo}}',
			},
			wed:{
				from:'{{is_null($availability->wedFrom)?'null':$availability->wedFrom}}',
				to:'{{is_null($availability->wedTo)?'null':$availability->wedTo}}',
			},
			thu:{
				from:'{{is_null($availability->thuFrom)?'null':$availability->thuFrom}}',
				to:'{{is_null($availability->thuTo)?'null':$availability->thuTo}}',
			},
			fri:{
				from:'{{is_null($availability->friFrom)?'null':$availability->friFrom}}',
				to:'{{is_null($availability->friTo)?'null':$availability->friTo}}',
			},
			sat:{
				from:'{{is_null($availability->satFrom)?'null':$availability->satFrom}}',
				to:'{{is_null($availability->satTo)?'null':$availability->satTo}}',
			},
			sun:{
				from:'{{is_null($availability->sunFrom)?'null':$availability->sunFrom}}',
				to:'{{is_null($availability->sunTo)?'null':$availability->sunTo}}',
			},
			hourLimit:'{{ empty($availability->hours)?'No information':"I can work up to $availability->hours hours per week" }}',
			holiday:'{{ empty($availability->holiday)? 'I can not work on holidays':'I can work on holidays'}}',
		}
		},
		submitAvailability(){
			axios.post('/employee_availability/add',{
				employee:app.currentEmployee,
				availability: app.availability
			}).then(function(response){
				if(response.data == 'success'){
					$.notify({
							title: 'Success!',
							message: 'Availability has been updated!'
						},{
							type:'success',
							placement: { from:'top',align:'center'}
						});
				}

				
			});
		}

	}
})

</script>
@endsection