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
				 		<span>@{{questionScore}}</span>
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
						<div class="col-8">
							<div class="m-demo__preview  m-demo__preview--btn">
								<button class="btn btn-info" type="button" @click="getPerformance">计算得分</button>
								<button class="btn btn-secondary" type="button" @click="showPerformance" data-toggle="modal" data-target="#m_modal_6">表现记录</button>
							</div>
							
						</div>
						
					</div>
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">店长评分</label>
						<div class="col-2">
							<input v-model="managerScore" class="form-control m-input" type="number"  min="0" max="20" step="1">
						</div>
					</div>
					
					<div class="m-form__group form-group row">
										<label class="col-2">员工自评</label>
										<div class="m-checkbox-list">
											<label class="m-checkbox m-checkbox--success" v-for="question in questions">
											<input type="checkbox" v-model="question.checked" :id="question.id" >@{{ question.question }}
											<span></span>
											</label>
											
											</label>
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
						<label class="col-2 col-form-label">员工自述</label>
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

<!-- Modal -->
<div class="modal fade" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">表现报告</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <div class="m-widget12">
			<div class="m-widget12__item">					 	 
				<span class="m-widget12__text1">开始日期<br><span>@{{ formattedDate(performanceRecords.from) }}</span></span> 			 		 
				<span class="m-widget12__text2">结束日期<br><span>@{{ formattedDate(performanceRecords.to) }}</span></span> 		 	 
			</div>
			
		</div>			 
        <!--begin::Section-->
				<div class="m-section">
					<div class="m-section__content">
						<table class="table table-striped m-table">
						  	<thead>
						    	<tr>
						      		<th>类别</th>
						      		<th>违规次数 / 允许次数</th>
						      		<th>项目</th>
						      		
						    	</tr>
						  	</thead>
						  	<tbody>
						    	<tr v-for="category in performanceRecords.categories">
							      	<th scope="row">@{{ category.name }}</th>
							      	<td class="text-center">@{{ category.infractions }} / @{{ category.allowance }}</td>
							      	<td class="text-right">
							      		<p v-for="item in category.items">@{{ item.score_item.name }} 
							      			<span v-if="item.value > 0" class="m--font-success">@{{ item.value }}</span>
							      			<span v-else class="m--font-danger">@{{ item.value }}</span>
							      			<span class="float right">@{{ formattedDate(item.date) }}</span>
							      		</p>
							      	</td>
							    
						    	</tr>
						    	
						  	</tbody>
						</table>
					</div>
				</div>
				<!--end::Section-->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

</div> <!-- root end -->

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
		pass: {{ $review->result }},
		performanceRecords:{},
		savedQuestions:'{!! json_encode($review->self_data,JSON_HEX_APOS) !!}',
		questions:[],

	},
	computed:{
		questionScore(){
			var score = 0;
			this.questions.forEach(question => {
				if(question.checked == true){
					score += 1;
				}
			});
			return score;
		},
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
		parseQuestions(){
			if(JSON.parse(this.savedQuestions) != null && JSON.parse(this.savedQuestions).length){
				this.questions = JSON.parse(this.savedQuestions);
			} else {
				this.questions = [
					{'id':1,'question':'对工作持积极态度,服从工作分配，减少管理成本，忠于职守，坚守岗位，出品合格','checked':false},
					{'id':2,'question':'工作积极主动，不违反规章制度，不打乱工作秩序，不妨碍他人工作','checked':false},
					{'id':3,'question':'半年里有受到客人或店长嘉令状表杨','checked':false},
					{'id':4,'question':'能带领及感召周围同事，协调上级，配合同事，同事关系融洽，形成团队凝聚力','checked':false},
					{'id':5,'question':'能主动参与周，月，季度卫生并做好记录，使门店工作顺利安全进行','checked':false},
					{'id':6,'question':'能发现工作中的问题，并提出解决问题的方案，用于现场管理','checked':false},
					{'id':7,'question':'能控制营运中复杂局面，能准确迅速完成上级交办的任务并有记录有交待','checked':false},
					{'id':8,'question':'严格遵守工作制度，有效利用工作时间，工作方法合理，各项资源的使用有效','checked':false},
					{'id':9,'question':'有责任心，工作能分清主次，业务处理得当，经常保持良好成绩','checked':false},
					{'id':10,'question':'着装整洁，礼貌待客，严守纪律，基本掌握业务知识，有节约意识','checked':false},
					];
			}
		},
		formattedDate(dt){
			return moment(dt).format('MMM D, YYYY');
		},
		getPerformance(){
		
			axios.post('/employeeReview/getPerformance',{
				employee: this.employee,
				reviewDate:this.reviewDate,
			}).then(res => {
				this.performance = res.data
			})
		},
		showPerformance(){
			axios.post('/employeeReview/showPerformance',{
				employee: this.employee,
				reviewDate:this.reviewDate,
			}).then(res => {
				console.log(res.data);
				this.performanceRecords = res.data;
			}).catch(e => console.log(e));
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
				selfScore: this.questionScore,
				questions: this.questions,
		
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
		this.parseQuestions();
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