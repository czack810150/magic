@extends('layouts.master')
@section('content')
<div class="container" id="page">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
           <li> <div id="clock" class="alert alert-info">
               
               </div>
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


@endsection

@section('pageJS')
<script>
  var currentQuestion = 0;
  var exam = {};
  var numOfQ = 0;
  var examStartTime = moment();
  var examEndTime = moment();
  var examTime = moment.duration(10,'seconds');
  console.log(examTime.asMinutes());


  function startExam(){
    $('#exam').html('Start Exam..');

    $.post(
         '/exam/attempt',
       {
           key: '{{$exam->id}}',
           _token: $('input[name="_token"]').val(),
       },
        function(data,status){
          if(status == 'success'){
            exam = data;
  
            numOfQ = data.questions.length;
            
            showQuestion(0);

          }
       },'json'
        );
    examStartTime = moment();
    examEndTime = examStartTime.add(1,'h');
    displayClock();

  }

  function displayClock(){
    const refresh = 1000;
    
      setInterval('displayTime()',refresh);
    
    
  }
  function displayTime(){
     examTime.subtract(1,'second');

if(examTime.asSeconds() == 0){
      alert('time is up!');
      submitExam();
    } else {
      if(examTime.asMinutes <= 5){
            $("#clock").removeClass('alert-info');
             $("#clock").html(examTime.minutes()+':'+examTime.seconds());
    } else {
              $("#clock").html(examTime.minutes()+':'+examTime.seconds());
    }
     
    }



    
   // var countDown = examEndTime - examStartTime
  
   
  }

  function showQuestion(index){
    currentQuestion = index;

    

    var q = exam.questions[index];

    console.log(q.question);

    var html = '<div class="card" style="width: auto;"><div class="card-body"><h5 class="card-title">'+ q.question.body +'</h5>';
    html += '<h6 class="card-subtitle mb-2 text-muted">'+ (currentQuestion+1) +'/'+(exam.questions.length) +'</h6>';

    if(q.question.mc){
      html += '<ul class="list-unstyled">';
                for(var i in q.answers){
    html += '<li class="mb-3"><input class="ml-2 mr-2" type="radio" name="question' + q.question_id + '" value="'+ q.answers[i].id +'" onclick="chooseAnswer(this,' + currentQuestion + ')">' + q.answers[i].answer +'</li>';
                }
        html += '</ul>';
         if(currentQuestion == exam.questions.length - 1){
          html += '<button class="btn btn-success" onclick="submitExam()">Submit Exam</button>';
        } else {
          var nextQuestion = currentQuestion + 1;
          html += '<button class="btn btn-primary" onclick="showQuestion('+ nextQuestion +')">Next</button>';
        }
        
    } else {
      html += '<textarea rows="10" cols="50" maxlength="400" id="sa' + currentQuestion + '" autofocus></textarea>';
       if(currentQuestion == exam.questions.length - 1){
          html += '<button class="btn btn-success" onclick="saveAndSubmitExam('+ currentQuestion +')">Submit Exam</button>';
        } else {
          
          html += '<button class="btn btn-primary" onclick="saveAndNext('+ currentQuestion +')">Next</button>';
        }
    }

          
      
        html += '</div></div>';
       $('#exam').html(html);

  }

  function saveAndSubmitExam(currentQuestion){
    exam.questions[currentQuestion].givenAnswer = $('textarea#sa'+ currentQuestion).val();
    submitExam();
  }

  function saveAndNext(currentQuestion){
    exam.questions[currentQuestion].givenAnswer = $('textarea#sa'+ currentQuestion).val();

    var nextQuestion = currentQuestion + 1;
    showQuestion(nextQuestion);
    console.log(exam.questions[currentQuestion]);
  }


  function chooseAnswer(e,questionIndex){
    exam.questions[questionIndex].givenAnswer = e.value;
  }

  function submitExam(){
    $.post(
      '/exam/submission',
      {
        exam : exam,
        _token: $('input[name="_token"]').val(),
      },
      function(data,status){
        if(status == 'success'){
          $('#page').html(data);
        }
      }
      );
  }

</script>
@endsection
