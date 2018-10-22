@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet" id="root">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="flaticon-users"></i>
				</span>
				<h3 class="m-portlet__head-text">
					Review Report for {{$employee->name}} 
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			
		</div>
	</div>

<!--begin::Form-->
	<form class="m-form m-form--fit m-form--label-align-right ">
		<div class="m-portlet__body">
			<!--begin::Widget 29-->
		<div class="m-widget29">			 
			<div class="m-widget_content">
				<h3 class="m-widget_content-title">评估得分</h3>
				<div class="m-widget_content-items">
				 	<div class="m-widget_content-item">
				 		<span>总分</span>
				 		<span class="m--font-accent">@{{total}}</span>
					</div>
					<div class="m-widget_content-item">
				 		<span>Review 结果</span>
				 		<span class="m--font-accent">@{{result}}</span>
					</div>
					<div class="m-widget_content-item">
				 		<span>调整建议</span>
				 		<span class="m--font-accent">@{{action}}</span>
					</div>			
					<div class="m-widget_content-item">
				 		<span>工作表现（70%）</span>
				 		<span class="m--font-brand">@{{performance}}</span>
					</div>
					<div class="m-widget_content-item">
				 		<span>店长评分（20%）</span>
				 		<span>@{{managerScore}}</span>
					</div>
					<div class="m-widget_content-item">
				 		<span>员工自评（10%）</span>
				 		<span>@{{selfScore}}</span>
					</div>
					<!-- <div class="m-widget_content-item">
				 		<span>公司人事</span>
				 		<span>29</span>
					</div>
					<div class="m-widget_content-item">
				 		<span>管理部</span>
				 		<span>29</span>
					</div> -->
				</div>	
			</div>
		</div>
		<!--end::Widget 29--> 
		<section v-if="!verified">
		<div class="m-form__group form-group row" >
				<label class="col-2 col-form-label">知识考试通过</label>
										<div class="col-2">
											<span class="m-switch">
												<label>
						                        <input type="checkbox" v-model="examPassed"/>
						                        <span></span>
						                        </label>
						                    </span>
										</div>
		</div>
		
					
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">工作表现</label>
						<div class="col-2">
							<input v-model="performance" class="form-control m-input" type="number" min="0" max="70">
						</div>
						<div class="col-2">
							<button class="btn btn-info" type="button" @click="getPerformance">Get Score</button>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">店长评分</label>
						<div class="col-2">
							<input v-model="managerScore" class="form-control m-input" type="number"  min="0" max="20" step="1">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">员工自评</label>
						<div class="col-2">
							<input v-model="selfScore" class="form-control m-input" type="number"  min="0" max="10" step="1">
						</div>
					</div>
					
					
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">考核日期</label>
						<div class="col-2">
							<input v-model="reviewDate"  id="reviewDate" class="form-control m-input" type="date">
						</div>
						<label class="col-2 col-form-label">下次考核</label>
						<div class="col-2">
							<input v-model="nextDate" id="nextDate" class="form-control m-input" type="date">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">店长评语</label>
						<div class="col-6">
							<textarea v-model="managerNote" class="form-control m-input" rows="8" maxlength="500"></textarea>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">员工自评</label>
						<div class="col-6">
							<textarea v-model="selfNote" class="form-control m-input" rows="8" maxlength="500"></textarea>
						</div>
					</div>
			</section>
		</div><!-- end of body -->
		<div class="m-portlet__foot m-portlet__foot--fit" v-if="!verified">
					<div class="m-form__actions">
						<div class="row">
							<div class="col-lg-9 ml-lg-auto">
								<button type="button" class="btn btn-warning" @click="updateReview">更新</button>
								
							</div>
						</div>
					</div>
				</div>
			
	</form>
</div>
@endsection
@section('pageJS')
<script>
 app = new Vue({
	el:'#root',
	data:{
		verified: {{ $review->verified}},
		id: {{$review->id}},
		employee: {{ $employee->id }},
		manager_id: {{ $employee->location->manager->id}},
		performance: {{ $review->performance }},
		managerScore: {{ $review->manager_score }},
		selfScore: {{ $review->self_score }},
		action: null,
		reviewDate:'{{ $review->reviewDate }}',
		nextDate: '{{ $review->nextReview }}',
		managerNote: '{{ $review->manager_note }}',
		selfNote:'{{ $review->self_note }}',
		examPassed:{{ $review->pass }},
		resultDescription:null,
		pass: {{ $review->result }}

	},
	computed:{
		total(){ 
			return +(this.performance) + +(this.managerScore) + +(this.selfScore)
		},
		result(){
			if(this.total >= 100 && this.examPassed) {
				this.action = '+$ 1.00'
				this.resultDescription = '极度卓越'
				this.pass = true;
				return '极度卓越'
			} else if(this.total >= 95 && this.examPassed){
				this.action = '+$ 0.75'
				this.resultDescription = '卓越'
				this.pass = true;
				return '卓越'
			} else if(this.total >= 85 && this.examPassed){
				this.action = '+$ 0.50'
				this.resultDescription = '优秀'
				this.pass = true;
				return '优秀'
			} else if(this.total >= 70 && this.examPassed) {
				this.action = '+$ 0.25'
				this.resultDescription = '良好'
				this.pass = true;
				return '良好'
			} else if(this.total >= 50 && this.examPassed){
				this.action = '薪资不变'
				this.resultDescription = '合格'
				this.pass = true;
				return '合格'
			} else {
				this.action = '-$ 0.50 或辞退'
				this.resultDescription = '不合格'
				this.pass = false;
				return '不合格'
			} 
		},
		
	},
	methods:{
		getPerformance(){
		
			axios.post('/employeeReview/getPerformance',{
				employee: this.employee,
				reviewDate:this.reviewDate,
			}).then(res => {
				this.performance = res.data
			})
		},
		updateReview()
		{
			axios.post('/employeeReview/updateReview',{
				employee: this.employee,
				id: this.id,
				reviewDate: this.reviewDate,
				nextReview: this.nextDate,
				performance: this.performance,
				managerScore: this.managerScore,
				selfScore: this.selfScore,
		
				managerNote: this.managerNote,
				selfNote: this.selfNote,
				examPassed: this.examPassed,
				resultDescription: this.resultDescription,
				pass: this.pass,


			}).then(res => {
				
				$.notify({
					message: res.data.message
				},{
					type:res.data.status,
					placement:{
						from:'top',
						align:'center',
					},
					animate: {
					enter: 'animated bounce',
					exit: 'animated fadeOutUp'
					}
				})
				if(res.data.status === 'success'){
					setTimeout(function(){
    					window.location.replace("/employeeReview");
						}, 2000);
				}
				
			}).catch(e => {
				console.log(e)
			})
		}
	},
	mounted(){
		$('#reviewDate').datepicker({
			autoclose:true,
			todayBtn:'linked',
			format:'yyyy-mm-dd'
		}).on('changeDate',e => {
			this.reviewDate = e.format('yyyy-mm-dd')
			this.nextDate = moment(e.format('yyyy-mm-dd')).add(180,'d').format('YYYY-MM-DD');
		});
	}

})
</script>
@endsection