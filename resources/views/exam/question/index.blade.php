@extends('layouts.master')
@section('content')

@include('exam.question.nav')


<!--Begin::Main Portlet-->
<div class="m-portlet" id="root">
  <div class="m-portlet__body m-portlet__body--no-padding">
    <div class="row m-row--no-padding m-row--col-separator-xl">
      <div class="col-md-12 col-lg-12 col-xl-4">
        <!--begin:: Widgets/Stats2-1 -->
<div class="m-widget1">
<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Category</h3>
				<span class="m-widget1__desc">题库类别</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-warning">{{ count($categories) }}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Total Questions</h3>
				<span class="m-widget1__desc">题库总量</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-info">{{ $stats['total'] }}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Multiple Choice</h3>
				<span class="m-widget1__desc">选择题</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-danger">{{ $stats['mc'] }}</span>
			</div>
		</div>
	</div>
	<div class="m-widget1__item">
		<div class="row m-row--no-padding align-items-center">
			<div class="col">
				<h3 class="m-widget1__title">Short Answer</h3>
				<span class="m-widget1__desc">简答题</span>
			</div>
			<div class="col m--align-right">
				<span class="m-widget1__number m--font-success">{{ $stats['sa'] }}</span>
			</div>
		</div>
	</div>
	
</div>
<!--end:: Widgets/Stats2-1 -->      
		</div>
      <div class="col-md-12 col-lg-12 col-xl-4">

<!--begin::Section-->
				<div class="m-section">
					
					<div class="m-section__content">
						<table class="table table-sm m-table m-table--head-bg-brand table-hover">
						  	<thead class="thead-inverse">
						    	<tr>
						      		<th>Category</th>
						      		<th>Questions</th>
						    	</tr>
						  	</thead>
						  	<tbody>
						  		@foreach($categories as $c)
						    	<tr @click="loadQuestions({{ $c->id }})">
							      	<th scope="row">	{{ $c->name }}</th>
							      	<td>{{ $c->question->count() }}</td>
						    	</tr>
	@endforeach
						    
						  	</tbody>
						</table>
					</div>
				</div>
				<!--end::Section-->
       </div>

       <div class="col-md-12 col-xl-4">
       	<table v-if="selected" class="table table-sm m-table m-table--head-bg-info table-hover">
       		<thead>
       			<tr><th>Question</th><th>Difficulty</th><th>Type</th></tr>
       		</thead>
       		<tbody>
       			<tr v-for="q in questions" >
       				<td><a :href="q.link">@{{ q.body }}</a></td>
       				<td>@{{ q.difficulty }}</td>
       				<td v-if="q.mc ==1">选择题</td>
       				<td v-else>简答题</td>

       			</tr>
       		</tbody>

       	</table>
       </div>

    </div>
  </div>
</div>
<!--End::Main Portlet-->



@endsection
@section('pageJS')
<script>
var app = new Vue({
	el:'#root',
	data:{
		questions:[],
	},
	computed:{
		selected(){
			return this.questions.length;
		}
	},
	methods:{
		loadQuestions(category){
			
			axios.get('/question/fetch/'+category)
			.then(res => {
				this.questions = res.data;
				console.log(this.questions);
			}).catch(e =>{
				alert(e);
				console.log(e);
			});
		}
	},
	mounted()
	{
		
	}

});


</script>
@endsection