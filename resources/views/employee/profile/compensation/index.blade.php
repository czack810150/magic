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
	</div>
	
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right">
<div class="m-portlet__body">
									
<div class="form-group m-form__group row">

	<compensation-item title="Pay Style" :body="type"></compensation-item>
	<compensation-item title="Rate" :body="formattedRate"></compensation-item>
	<compensation-item title="Basic Rate" body="${{ number_format($basicRate->minimumPay/100,2,'.',',') }} / Hour"></compensation-item>
	<compensation-item title="Position Rate" body="${{ number_format($employee->job->rate/100,2,'.',',') }} / Hour"></compensation-item>
	<div class="col-md-2">
<div class="info-box pl-3">
<small>Tipping
</small>
@if($employee->job->tip)
<p>{{ $employee->job->tip*100 }}%</p>
@else
<p>Receives no tips</p>
@endif
</div>
</div>
	<compensation-item title="Meal Rate" body="${{ number_format($basicRate->mealRate,2,'.',',') }} / Hour"></compensation-item>
	<compensation-item title="Night Rate" body="${{ number_format($basicRate->nightRate,2,'.',',') }} / Hour"></compensation-item>

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
						<label>Rate</label>
						<input type="number" v-model="selectedRate" class="form-control m-input" min="0" step="0.25" required>
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
						      		<th>From</th>
						      		<th>To</th>
						      		<th>Rate</th>
						      		<th>Change</th>
						    	</tr>
						  	</thead>
						  	<tbody>
						    	<compensation-table-row v-for="rate in rates" 
						    	:key="rate.id"
						    	:type="rate.type"
						    	:cheque="rate.cheque"
						    	:rate="rate.rate"
						    	:start="rate.start"
						    	:end="rate.end"
						    	:change="rate.change"
						    	></compensation-table-row>
						  	</tbody>
						</table>
					</div>
				</div>
				<!--end::Section-->
	`,
	
});

Vue.component('compensation-table-row',{
	props:['type','cheque','rate','start','end','change'],
	template:`
	<tr><td>@{{type}}</td>@{{start}}<td>@{{end}}</td><td>@{{rate/100}}</td><td>@{{change/100}}</td><td></td><td></td></tr>
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
		type: '{{ count($employee->rate)?$employee->rate->last()->type:"Not Available" }}',
		rate: '{{ count($employee->rate)?$employee->rate->last()->rate:"No Information" }}',
		cheque: '{{ count($employee->rate)?$employee->rate->last()->cheque:1 }}',
		minimumRate: {{$basicRate->minimumPay }},
		rates: [
			@if(count($employee->rate))
				@foreach($employee->rate as $r)
					{ type: '{{$r->type}}',cheque: '{{$r->cheque}}', rate: {{$r->rate}}, start:'{{$r->start}}',end:'{{$r->end}}',change:{{$r->change}} },
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
		selectedRate: {{ count($employee->rate)?$employee->rate->last()->rate/100:0 }},
		effectiveDate: moment().add(1,'d').format('YYYY-MM-DD'),
	},
	computed:{
		formattedRate(){
			if(!$.isNumeric(this.rate)) {
				return this.rate;
			} else {
				return '$' + this.rate / 100 + ' /' + this.type;
			}
			
		}
	},
	methods:{
		submitRate(){
			axios.post('/rateSubmit',{
				employee:{{$employee->id}},
				type: this.selectedType,
				rate: this.selectedRate,
				cheque:this.cheque,
				startDate:this.effectiveDate,
			}).then(response => {
				$('#newRateModal').modal('hide');
				this.updateRates();
				this.rate = this.selectedRate*100;
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


