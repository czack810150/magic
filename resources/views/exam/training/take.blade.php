@extends('layouts.master')
@section('content')
<style>
.answer-option:hover{
	/* background-color:#f3f3f3; */
}
.selected{
	background-color:green;
}
</style>
<!--begin::Portlet-->
<div class="m-portlet m-portlet--full-height" id="root">
						
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-clipboard"></i>
												</span>
												<h3 class="m-portlet__head-text">
													<span v-text="exam.name"></span>
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
										
												<li class="m-portlet__nav-item">
												<a href="/exam/learn/" class="btn btn-metal">返回</a>
														
												
												</li>
								
											</ul>
										</div>
									</div>
<div class="m-portlet__body" v-show="testStage">
<h3>Questions @{{questions.length}}</h3>

<div class="card" style="width:48rem;">
<div class="card-body">
<h5 class="card-title"><span>@{{index+1}}/@{{questions.length}}</span> @{{questions[index].question.body}}</h5>
<h6 class="card-subtitle mb-2 text-muted">@{{questions[index].question.question_category.name}}</h6>

</div>
<div class="card">
<ul class="list-group list-group-flush">
    <li class="list-group-item answer-option" v-for="answer in questions[index].question.answer" v-text="answer.answer"
		@click="chooseAnswer(questions[index],answer)" v-bind:class="{ 'alert alert-info': questions[index].answer_id == answer.id}"
	></li>
  
  </ul>
</div>


<div class="card-body">
<button class="card-link btn btn-info" @click="prev" :disabled="index == 0">Previous</button>
<button  class="card-link btn btn-info" @click="next" :disabled="index == (questions.length-1)">Next</button>
<button  class="card-link btn btn-success" @click="submit" :hidden="index != (questions.length-1)  ">Submit</button>
</div>
</div>


</div>
<div class="m-portlet__body" v-show="resultStage">
<!--begin::Widget 29-->
<div class="m-widget29">			 
			<div class="m-widget_content">
				<h3 class="m-widget_content-title">测验结果</h3>
				<div class="m-widget_content-items">
				 	<div class="m-widget_content-item">
				 		<span>题目总数</span>
				 		<span class="m--font-accent">@{{result.questions}}</span>
					</div>	
					<div class="m-widget_content-item">
				 		<span>正确答案</span>
				 		<span class="m--font-brand">@{{result.score}}</span>
					</div>
					<div class="m-widget_content-item">
				 		<span>正确率</span>
				 		<span>@{{result.percentage}}%</span>
					</div>
				</div>	
			</div>
</div>
</div>

</div>
<!--end::Portlet-->
@endsection
@section('pageJS')
<script>

var vm = new Vue({
    el: '#root',
    data: {
		testStage:false,
		resultStage:true,
        exam: @json($exam),
        questions: @json($questions),
		index:0,
		result:[],
		start: moment().format('YYYY-MM-DD HH:mm:ss'),
		end:''
    },
	methods:{
		next(){
			if(this.index < this.questions.length-1){
				this.index++
			}
			
		},
		prev(){
			if(this.index > 0){
				this.index--
			} 
		},
		chooseAnswer(question,answer){
			question.answer_id = answer.id

		},
		submit(){
			this.end = moment().format('YYYY-MM-DD HH:mm:ss');
			axios.post('/exam/learn/'+this.exam.id+'/update',{
				_token:'{{csrf_token()}}',
				questions: this.questions,
				start: this.start,
				end: this.end

			}).then(function(response){
				vm.result = response.data
				vm.testStage = false;
				vm.resultStage = true;
			})
		},
		randomList: function(array){
        var currentIndex = array.length;
        var temporaryValue;
        var randomIndex;
        var myRandomizedList;

        // Clone the original array into myRandomizedList (shallow copy of array)
        myRandomizedList = array.slice(0)

        // Randomize elements within the myRandomizedList - the shallow copy of original array
        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = myRandomizedList[currentIndex];
            myRandomizedList[currentIndex] = myRandomizedList[randomIndex];
            myRandomizedList[randomIndex] = temporaryValue;
        }

        // Return the new array that has been randomized
        return myRandomizedList;
    }
	},
    mounted(){
        this.testStage = true;
		this.resultStage = false;
		for(question of this.questions){
			question.question.answer = this.randomList(question.question.answer)
			
		}
	
    }
})

</script>
@endsection