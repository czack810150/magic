<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question_category;
use App\Location;
use App\Question;
use App\Answer;
use App\Exam;
use App\Exam_question;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;


class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('exam.exam.index');
    }
    public function all()
    {
        $exams = Exam::get();

        return view('exam.exam.all',compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::store()->get();
        $categories = Question_category::get();
        $questions = Question::where('Question_category_id',1)->get();
        return view('exam.exam.create',compact('categories','locations','questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = json_decode(request('json'));
   

        $exam = new Exam;
        $exam->employee_id = $json->employee;
        $exam->name = $json->name;
        $exam->access = str_random(64);
        $exam->save();

        foreach($json->questions as $q){
            $question = Exam_question::create(['question_id'=>$q->id]);
            $exam->question()->save($question);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exam = Exam::find($id);
        return view('exam.exam.exam',compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Exam::destroy($id);
        return redirect('/exam/all');
    }
    public function take($access)
    {
        if(strlen($access) == 64){
          $exam = Exam::where('access',$access)->first();
          if($exam){
                if($exam->finished){
                    return 'exam has been taken.';
                } else {
                     return view('exam.take.index')->withExam($exam);
                }
              
          } else {
             return 'Wrong KEY';
         }
        } else return 'wrong examination key';
    }
    public function attempt(Request $r)
    {   
        $app = app();
           
         // $exam = Exam_question::where('exam_id',$r->key)->get();
            $exam = Exam::find($r->key);
            //return $exam->id;
          if($exam){
             $examContent = $app->make('stdClass');
             $examContent->exam_id = $exam->id;
             $examContent->employee_id = $exam->employee_id;
              $examContent->questions = array();
             foreach(Exam_question::where('exam_id',$r->key)->pluck('question_id') as $question ){
                $examContent->questions[] = new QuestionContent($question);
             } 
            
             $exam->taken_at = Carbon::now('America/Toronto');
             $exam->save();
             return json_encode($examContent);
          } else {
             return 'Wrong KEY';
            }      
    }

    public function submitExam(Request $r)
    {
        $score = 0;
        $exam_id = $r->exam['exam_id'];
        $employee_id = $r->exam['employee_id'];
        
        foreach($r->exam['questions'] as $q){
            if(!is_null($q['givenAnswer'])){
                $examQuestion = Exam_question::where('exam_id',$exam_id)->where('question_id',$q['question_id'])->first();
                if($q['question']['mc']){
                  $examQuestion->answer_id = $q['givenAnswer'];
                  $correctAnswer = Answer::where('question_id',$q['question_id'])->correct()->first();
                  if($q['givenAnswer'] == $correctAnswer->id){
                    $score += 1;
                  }

                } else {
                  $examQuestion->short_answer = $q['givenAnswer'];  
                } 
                
                $examQuestion->save();
            }
        }

        $exam = Exam::find($exam_id);
        $exam->finished = true;
        $exam->score = $score;
        $exam->save();

        if(View::exists('exam.exam.finish')){
            return View::make('exam.exam.finish')->render();
        }
    }

}


class QuestionContent {
    public $question_id;
    public $question;
    public $answers = array();
    public $givenAnswer;
    function __construct($question_id){
        $this->question_id = $question_id;
        $this->question = Question::find($question_id);
        $this->answers = Answer::where('question_id',$question_id)->select('id','answer')->inRandomOrder()->get();
    }
}
