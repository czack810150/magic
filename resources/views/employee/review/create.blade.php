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
				 		<span>@{{manager}}</span>
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


		
					
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">工作表现</label>
						<div class="col-2">
							<input v-model="performance" class="form-control m-input" type="number" min="0" max="70">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-2 col-form-label">店长评分</label>
						<div class="col-2">
							<input v-model="manager" class="form-control m-input" type="number"  min="0" max="20" step="1">
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
							<input v-model="reviewDate.format('YYYY-MM-DD')"  class="form-control m-input" type="date">
						</div>
						<label class="col-2 col-form-label">下次考核</label>
						<div class="col-2">
							<input v-model="nextDate.format('YYYY-MM-DD')" class="form-control m-input" type="date">
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
				
		</div><!-- end of body -->
	</form>
</div>
@endsection
@section('pageJS')
<script>
 app = new Vue({
	el:'#root',
	data:{
		employee: {{ $employee->id }},
		performance: 0,
		manager: 0,
		selfScore: 0,
		action: null,
		reviewDate:moment(),
		managerNote:null,
		selfNote:null,
		

	},
	computed:{
		total(){ 
			return +(this.performance) + +(this.manager) + +(this.selfScore)
		},
		result(){
			if(this.total >= 100) {
				this.action = '+$ 1.00'
				return '极度卓越'
			} else if(this.total >= 95){
				this.action = '+$ 0.75'
				return '卓越'
			} else if(this.total >= 85){
				this.action = '+$ 0.50'
				return '优秀'
			} else if(this.total >= 70){
				this.action = '+$ 0.25'
				return '良好'
			} else if(this.total >= 50){
				this.action = '薪资不变'
				return '合格'
			} else {
				this.action = '-$ 0.50 或辞退'
				return '不合格'
			} 
		},
		nextDate(){
			return this.reviewDate.add(180,'d')
		}
	},

})
</script>
@endsection