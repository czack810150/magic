<!--begin::Portlet-->
<div class="m-portlet" id="employee-compensation">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				
				<h3 class="m-portlet__head-text">
					Salary <small>Details</small>
				</h3>
			</div>
		</div>
	@can('update-salary')
	<div class="m-portlet__head-tools">
		<ul class="m-portlet__nav">
			<li class="m-portlet__nav-item">
				<button class="btn btn-sm btn-primary m-btn m-btn--icon" data-toggle="modal" data-target="#newRateModal">
					<span><i class="la la-plus"></i>
					<span>New Rate</span>
					</span>
				</button>
			</li>
		</ul>
	</div>
	@endcan
	</div>
	
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right">
<div class="m-portlet__body">
									
<div class="form-group m-form__group row">

	<compensation-item title="Pay Style" :body="type"></compensation-item>
	<compensation-item v-if="type=='hour'" title="时薪" :body="overallRate"></compensation-item>
	<compensation-item v-if="type=='hour'" title="Basic Rate" :body="formattedBasicRate"></compensation-item>
	<compensation-item v-if="type=='hour'" title="Variable Rate" :body="formattedRate"></compensation-item>
	<compensation-item v-if="type=='month'" title="Monthly Rate" :body="formattedRate"></compensation-item>

	
	<compensation-item v-if="employeeRole == 'noodle' " title="Skill Rate" :body="formattedExtraRate"></compensation-item>
	
	<compensation-item  v-if="employeeType == 'store'" title="Tipping" :body="tipping"></compensation-item>

	<compensation-item  v-if="employeeType == 'store'" title="Meal Rate" body="${{ number_format($basicRate->mealRate,2,'.',',') }} / Hour"></compensation-item>
	<compensation-item v-if="employeeType == 'store'" title="Night Rate" body="${{ number_format($basicRate->nightRate,2,'.',',') }} / Hour"></compensation-item>

</div> <!--end of row-->
</div>
</form><!--end::Form-->

<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				
				<h3 class="m-portlet__head-text">
					History<small>历史薪资</small>
				</h3>
			</div>
		</div>	
</div>
<div class="m-portlet__body">
	<section v-if="rates.length">
		<compensation-table :rates="rates"></compensation-table>
	</section>
	<section v-else>
		<p>No rate history</p>
	</section>
</div>
@can('update-salary')
<!-- Modal -->
<div class="modal fade" id="newRateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Rate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
 
        <!--begin::Form-->
			<form class="m-form m-form--fit m-form--label-align-right">
				<div class="modal-body">
					<div class="form-group m-form__group">
						<label>Salary Style</label>
						<select class="form-control m-input" v-model="selectedType">
							<option v-for="type in types" :value="type.value" v-text="type.name"></option>
						</select>
					</div>
				
					<div class="form-group m-form__group">
						<label>基本工资</label>
						<input type="number" v-model="selectedRate" class="form-control m-input" min="-.5" step="0.25" required>
					</div>
					<div class="form-group m-form__group">
						<label>浮动工资</label>
						<input type="number" v-model="selectedVariableRate" class="form-control m-input" min="-.5" step="0.25" max="4" required>
					</div>
					<div class="form-group m-form__group">
						<label>技能工资</label>
						<input type="number" v-model="selectedExtraRate" class="form-control m-input" min="0" step="1" max="6" required>
					</div>
					<div class="form-group m-form__group">
						<label>Effective Date</label>
						<input type="date" class="form-control m-input" v-model="effectiveDate" id="effectiveDate">
					</div>
					<div class="m-form__group form-group">
						<label>是否可以打税</label>
						<div class="m-checkbox-list">
							<label class="m-checkbox">
							<input type="checkbox" v-model="cheque"> 可以打税
							<span></span>
							</label>
						</div>
					</div>
					
					
					
				</div>
				
			</form>
			<!--end::Form-->		
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="submitRate">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal end -->
@endcan
															
</div><!--end::Portlet-->



<script>
Vue.component('compensation-table',{
	props:['rates'],
	template:`
	<!--begin::Section-->
				<div class="m-section">
					<div class="m-section__content">
						<table class="table table-striped table-sm m-table">
						  	<thead>
						    	<tr>
						    		<th>Style</th>
						    		<th>打税</th>
						      		<th>From</th>
						      		<th>To</th>
						      		<th>Rate</th>
						      		
						    	</tr>
						  	</thead>
						  	<tbody>
						    	<compensation-table-row v-for="rate in rates" 
						    	:key="rate.id"
						    	:type="rate.type"
						    	:cheque="rate.cheque"
						    	:rate="rate.rate"
						    	:variableRate="rate.variableRate"
						    	:extraRate="rate.extraRate"
						    	:start="rate.start"
						    	:end="rate.end"
					
						    	></compensation-table-row>
						  	</tbody>
						</table>
					</div>
				</div>
				<!--end::Section-->
	`,
	
});

Vue.component('compensation-table-row',{
	props:['type','cheque','rate','variableRate','extraRate','start','end','change'],
	template:`
	<tr><td>@{{type}}</td><td>@{{ cheque }}</td>@{{start}}<td>@{{end}}</td><td>@{{(rate + variableRate + extraRate)/100}}</td><td></td><td></td></tr>
	`
});

Vue.component('compensation-item',{
	props:['title','body'],
	template:`
	<div class="col-md-2">
<div class="info-box pl-3">
<small>@{{title}}</small>
<p>@{{ body }}</p>
</div>
</div>
	`
})


var app = new Vue({
	el:'#employee-compensation',
	data:{
		employeeType: '{{ $employee->location->type }}',
		employeeRole: '{{ $employee->job->type }}',
		tipping : '{{$employee->job->tip? ($employee->job->tip*100)." %":"Receives no tips"}}',

		type: '{{ count($employee->rate)?$employee->rate->last()->type:"Not Available" }}',
		variableRate: '{{ count($employee->rate)?$employee->rate->last()->variableRate:"No Information" }}',
		cheque: '{{ count($employee->rate)?$employee->rate->last()->cheque:1 }}',
		basicRate: {{ $employee->rate->last()->rate }},
		extraRate: {{ $employee->rate->last()->extraRate }},
		rates: [
			@if(count($employee->rate))
				@foreach($employee->rate as $r)
					{ type: '{{$r->type}}',cheque: '{{$r->cheque}}', rate: {{$r->rate}}, start:'{{$r->start}}',end:'{{$r->end}}',
						variableRate:{{$r->variableRate}},
						extraRate:{{$r->extraRate}},
					 },
				@endforeach
			@endif
		],
		types:[
		{
			value:'hour',name:'Hourly'
		},
		{
			value:'month',name:'Monthly'
		},
		],
		selectedType: '{{ count($employee->rate)?$employee->rate->last()->type:"hour" }}',
		selectedRate: {{ count($employee->rate)? $employee->rate->last()->rate/100:0 }},
		selectedVariableRate: {{ $employee->rate->last()->variableRate }}/100,
		selectedExtraRate:{{ $employee->rate->last()->extraRate }}/100,
		effectiveDate: moment().add(1,'d').format('YYYY-MM-DD'),
	},
	computed:{
		formattedRate(){
			if(!$.isNumeric(this.variableRate)) {
				return this.variableRate;
			} else {
				return '$' + parseInt(this.variableRate) / 100 + ' /' + this.type;
			}
			
		},
		overallRate(){
			if(!$.isNumeric(this.variableRate)) {
				return (this.basicRate + this.extraRate)/100
			} else {
				return '$' + (this.basicRate + this.extraRate + parseInt(this.variableRate))/100 + ' /' + this.type;
			}
		},
		formattedBasicRate(){
			return '$' + this.basicRate / 100 + ' /' + this.type;
		},
		formattedExtraRate(){
			return '$' + this.extraRate / 100 + ' /' + this.type;
		}

	},
	methods:{
		submitRate(){
			axios.post('/rateSubmit',{
				employee:{{$employee->id}},
				type: this.selectedType,
				rate: this.selectedRate,
				variableRate: this.selectedVariableRate,
				extraRate:this.selectedExtraRate,
				cheque:this.cheque,
				startDate:this.effectiveDate,
			}).then(response => {
				$('#newRateModal').modal('hide');
				this.updateRates();
				this.basicRate = this.selectedRate*100;
				this.variableRate = this.selectedVariableRate*100;
				this.extraRate = this.selectedExtraRate*100;
				this.type = this.selectedType;
			});
			
		},
		updateRates(){
			axios.post('/rateGet',{
				employee:{{$employee->id}},
			}).then(response => {
				app.rates = response.data;
			})
		}
	},
	mounted(){
		$('#effectiveDate').datepicker({
			format:'yyyy-mm-dd',
		});
		$('#effectiveDate').datepicker().on('changeDate',e => {
			app.effectiveDate = e.format('yyyy-mm-dd');
		})
	}
});
</script>


