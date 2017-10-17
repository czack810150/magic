@extends('layouts.master')
@section('content')
<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
           
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">{{$exam->employee->cName}} {{$exam->name}}</h3>
      </div>

      <div class="jumbotron">
        <h1 class="display-3">你好！ {{$exam->employee->cName}} {{$exam->employee->employeeNumber}}</h1>
        <p class="lead">恭喜您！ 你在大槐树就职于{{$exam->employee->hired->diffForHumans()}}.</p>
        <p class="lead">本次考试共{{$exam->question->count()}}个题。其中还选择题个，简答题个。</p>
        <p><button class="btn btn-lg btn-success" onclick="startExam()" role="button">开始考试</button></p>
      </div>
      <main id="exam">
      </main>

      

      <footer class="footer">
        <p>&copy; Magic Noodle 2017</p>
      </footer>

    </div> <!-- /container -->
    {{csrf_field()}}
<script>
	function startExam(){
		$('#exam').html('Start Exam..');

		$.post(
     		 '/exam/attempt',
     	 {
       		 key: '{{$exam->access}}',
       		 _token: $('input[name="_token"]').val(),
     	 },
    	  function(data,status){
      		if(status == 'success'){
      			$('#exam').html(data);
      		}
     	 }
   	    );

	}
</script>

@endsection
