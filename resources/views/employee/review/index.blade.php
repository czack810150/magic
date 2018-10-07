@extends('layouts.master')
@section('content')
<!--begin::Portlet-->
<div class="m-portlet">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="flaticon-users"></i>
				</span>
				<h3 class="m-portlet__head-text">
					Review Reports
				</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			
		</div>
	</div>
	<div class="m-portlet__body" id="root">
			
			<review-table :reviews="sortedReviews"></review-table>
			
	</div>			
</div>

@endsection
@section('pageJS')
<script>
Vue.component('review-table',{
	props:['reviews'],
	template:
	`<table class="table">

				<thead>
					<tr>
						<th>Location</th>
						<th>Employee</th>
						<th>状态</th>
						<th>考核日期</th>
						<th>下次考核</th>
						<th>考试通过</th>
						<th>考核人</th>
						<th>表现</th>
						<th>店长评分</th>
						<th>自评分</th>
						<th>结果</th>
						<th>成绩</th>
						<th>Actions</th>
					
					</tr>
				</thead>
				<tbody>
					
					<review-row-component v-for="review in reviews" :key="review.id" :id="review.id"
						:location="review.employee.location.name"
						:employee="review.employee.name"
						:reviewed="review.reviewed"
						:review_date="review.reviewDate"
						:next_review="review.nextReview"
						:exam_pass="review.pass"
						:manager="review.manager.name"
						:performance="review.performance"
						:manager_score="review.manager_score"
						:self_score="review.self_score"
						:result="review.result"
						:description="review.description"
						:manager_note="review.manager_note"
						:self_note="review.self_note"
						:verified="review.verified"
					></review-row-component>
					
				</tbody>

			</table>`
});	
Vue.component('review-row-component',{
	props:['id','location','employee','reviewed','review_date','next_review','exam_pass','manager','manager_score','self_score','result','description','manager_note','self_note','performance','verified'],
	template:
	`
	<tr>
		<td>@{{ location}}</td>
		<td>@{{ employee }}</td>
		<td>@{{ reviewed? '已考核':'未考核' }}</td>
		<td>@{{ review_date }}</td>
		<td>@{{ next_review }}</td>
		<td>@{{ exam_pass? '通过':'不过' }}</td>
		<td>@{{ manager }}</td>
		<td>@{{ performance }}</td>
		<td>@{{ manager_score }}</td>
		<td>@{{ self_score }}</td>
		<td>@{{ result?"通过":'不过' }}</td>
		<td>@{{ description }}</td>
		<td><a class="btn btn-warning btn-sm" :href="'/employeeReview/'+id+'/view'">查看</a>
		<button v-if="!verified" class="btn btn-success btn-sm" type="button" @click="verifyReview">批准</button></td>
	</tr>
	`,
	methods:{
		verifyReview(){
			axios.post('/employeeReview/verify',{
				review:this.id
			}).then(res => {
				
					app.getReviews();
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
				});
				
			});
		}
	}
})
var app =  new Vue({
	el: '#root',
	data: {
		reviews:[],
	},
	computed: {
		sortedReviews(){
			return this.reviews.sort((a,b) => {
				return b.created_at - a.created_at;
			});
		}
	},
	methods:{
		getReviews(){
			axios.get('/employeeReview/getAllReviews').then(res => {
			this.reviews = res.data;
		})
		}
	},
	mounted(){
		this.getReviews();
	}
})
 
</script>
@endsection