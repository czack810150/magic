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
<div class="m-portlet__body">
<h3>Questions @{{questions.length}}</h3>

<div class="card mb-5" style="width:48rem;" v-for="question in questions">
<div class="card-body">
<h5 class="card-title"> @{{question.question.body}}</h5>
<h6 class="card-subtitle mb-2 text-muted">@{{question.question.question_category.name}}</h6>

</div>
<div class="card">
<ul class="list-group list-group-flush">
    <li class="list-group-item answer-option" v-for="answer in randomList(question.question.answer)" v-text="answer.answer"
		 v-bind:class="classChooser(question,answer)"
         
	></li>
  
  </ul>
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
        exam: @json($exam),
        questions: @json($questions),
    },
	methods:{
        classChooser(question,answer){
            if(question.answer_id == answer.id && answer.correct == 1 || answer.correct == 1){
                return 'alert alert-success'
            } else if(question.answer_id == answer.id && answer.correct != 1) {
                return 'alert alert-danger'
            } 
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
     
    }
})

</script>
@endsection