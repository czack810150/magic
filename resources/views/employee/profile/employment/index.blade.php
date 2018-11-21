<!--begin::Portlet-->
<div class="m-portlet">
<div id="employmentDetails">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				
				<h3 class="m-portlet__head-text">
					Employment <small>Details</small>
				</h3>
			</div>
		</div>
		@can('update-employment')
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<a href="javascript:editEmployment({{ $employee->id }})" class="m-portlet__nav-link m-portlet__nav-link--icon">
						<i class="la la-edit"></i>
					</a>
				</li>
			</ul>
		</div>
		@endcan
	</div>
<div class="m-portlet__body">

<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>Job Title</small>
<p>{{ $employee->job->rank }} </p>
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Employee ID</small>
@if(!empty($employee->employeeNumber))
<p>{{ $employee->employeeNumber }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Date Hired</small>
@if(!empty($employee->hired))
<p>{{ $employee->hired->toFormattedDateString() }}</p>
@else
<p>-</p>
@endif
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Termination Date</small>
@if(!empty($employee->termination) )
<p>{{ $employee->termination->toFormattedDateString() }}</p>
@else
<p>-</p>
@endif
</div>
</div>

</div> <!-- end of row -->

@if($employee->user)
<div class="row">
<div class="col-3">
<div class="info-box pl-3">
<small>User Type</small>
<p>{{ $employee->user->type }} </p>
</div>
</div>
<div class="col-3">
<div class="info-box pl-3">
<small>Location</small>
<p>{{ $employee->location->name }} </p>
</div>
</div>

<div class="col-3">
<div class="info-box pl-3">
<small>Supervisor</small>
<p>{{ $employee->job_group == 'supervisor'?'Yes':'No' }} </p>
</div>
</div>


</div> <!-- end of row -->
@endif


<div class="row">

<div class="col-3">
<div class="info-box pl-3">
<small>SIN</small>

@if($employee->employee_profile->sin)
<p>{{ $employee->employee_profile->sin }} </p>
@else
<p>-</p>
@endif

</div>

</div> <!-- end of row -->


</div><!-- m-portlet__body -->

</div><!-- end of employment detailes -->


<div id="employmentHistory">
	
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				
				<h3 class="m-portlet__head-text">
					老员工历史 <small>Employment Legacy</small>
				</h3>
			</div>
		</div>
		@can('update-employment')
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<button class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only" @click="showForm">
						<i class="la la-plus"></i>
					</button>
				</li>
			</ul>
		</div>
		@endcan
	</div>
<div class="m-portlet__body">

<form class="m-form m-form--fit m-form--label-align-right" v-if="displayForm">
				
		<div class="form-group m-form__group m--margin-top-10">
			<div class="alert m-alert m-alert--default" role="alert">
				在此可以录入老员工的工资历史信息，诸如门店，职位，工时，时薪等数据
			</div>
		</div>
		
		
		<div class="form-group m-form__group">
			<label>Location</label>
			<select class="form-control m-input" v-model="newLegacy.location.name">
				<option value="" disabled>Choose one</option>
				<option value="Scarborough">Scarborough</option>
				<option value="Richmond Hill">Richmond Hill</option>
				<option value="Downtown">Downtown</option>
				<option value="North York">North York</option>
				<option value="Kitchen">Kitchen</option>
			</select>
		</div>

		<div class="form-group m-form__group">
			<label>工作职位岗位</label>
			<input type="text" v-model="newLegacy.location.job" class="form-control m-input"  placeholder="输入岗位或职位名称">
			<span class="m-form__help">历史岗位可能与当前不同，需要直接输入</span>
		</div>
		<div class="form-group m-form__group">
			<label>时薪</label>
			<input type="text" v-model="newLegacy.location.rate" class="form-control m-input"  placeholder="输入当时时薪 如 12.25">
		</div>
		<div class="form-group m-form__group">
			<label>工时</label>
			<input type="number" v-model="newLegacy.location.hours" class="form-control m-input"  placeholder="输入历史工时" min="0" step="1">
		</div>
		<div class="form-group m-form__group">
			<label>开始日期</label>
			<input type="text" id="from" v-model="newLegacy.location.from" class="form-control m-input"  placeholder="YYYY-MM-DD">
		</div>
		<div class="form-group m-form__group">
			<label>结束日期</label>
			<input type="text" id="to" v-model="newLegacy.location.to" class="form-control m-input"  placeholder="YYYY-MM-DD">
		</div>
		
	
	<div class="m-portlet__foot m-portlet__foot--fit">
		<div class="m-form__actions">
			<button type="button" class="btn btn-primary" @click="submitLegacy">Submit</button>
			<button type="button" class="btn btn-secondary" @click="hideForm">Cancel</button>
		</div>
	</div>
	
</form>
<!--end::Form-->	



</div><!-- m-portlet__body -->
	
</div><!-- end of employment history -->				

</div>
<!--end::Portlet-->
<script>
	var app = new Vue({
		el: '#employmentHistory',
		data:{
			legacy:null,
			newLegacy:{
				location:{
					name:'',
					from:null,
					to:null,
					job:null,
					rate:null,
				},
			},
			displayForm:false,
		},
		methods:{
			getHistory(){
				axios.get('/employee/{{ $employee->id }}/legacy')
				.then(res => {
					console.log(res.data);
					this.legacy = res.data;
				}).catch(e => {
					alert(e);
					console.log(e);
				});
			},
			showForm(){
				this.displayForm = true;
			},
			hideForm(){
				this.displayForm = false;
			},
			submitLegacy(){
				
				axios.post('/employee/legacy',{
					employee: {{ $employee->id }},
					legacy:this.newLegacy,
				}).then(res => {
					console.log(res.data);
				}).catch(e => {
					
				});

			}
		},
		mounted(){
			this.getHistory();
			$('#from').datepicker();
			$('#to').datepicker();
		}
	});

</script>