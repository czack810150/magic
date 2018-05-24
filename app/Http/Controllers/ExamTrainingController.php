<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamTraining;
use App\ExamTrainingQuestion;
use App\Question_category;
use App\Question;
use App\Answer;
use Faker\Generator as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ExamTrainingController extends Controller
{
   
    public function index()
    {
        $subheader = 'Training';

        $exams = ExamTraining::get();
        // $attempted = Exam::where('taken_at','!=',null)->get()->count();
        // $templates = 0;
        // $questions = Question::get()->count();
        // $mc = Question::where('mc',1)->get()->count();
        // $sa = Question::where('mc',0)->get()->count();
        // $templates = Exam_template::get()->count();
        
        return view('exam.training.index',compact('subheader','exams'));
    }

    public function create()
    {
        $subheader = 'Employee Training';
        $categories = Question_category::get();
        return view('exam.training.create',compact('categories','subheader'));
    }

    public function store(Request $request)
    {
        $mock = ExamTraining::create([
            'employee_id' => Auth::user()->authorization->employee_id,
        ]);
        $questionsForEach = floor($request->count / count($request->cats));
        $remainder = $request->count % count($request->cats);
        // add questions to each category
        foreach($request->cats as $c){
           $questions = Question::where('question_category_id',$c['id'])->where('mc',true)->get();
            if(count($questions) < $questionsForEach ){
                
            } else {
                $questions = Question::where('question_category_id',$c['id'])->where('mc',true)->get()->random($questionsForEach);
            }
            foreach($questions as $q){
                ExamTrainingQuestion::create([
                    'exam_training_id' => $mock->id,
                    'question_id' => $q->id
                ]);
            }
           
        }
        //deal with the remainder questions
        $categoryIds = collect($request->cats)->pluck('id');
        if($remainder){
        for($i = 0; $i < $remainder; $i++)
        {
            $question = Question::whereIn('question_category_id',$categoryIds)->where('mc',true)->get()->random();
            if(count($questions)){
                ExamTrainingQuestion::create([
                    'exam_training_id' => $mock->id,
                    'question_id' => $question->id
                ]);
            }
        }
        }
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subheader = 'Training';
        $exam = ExamTraining::findOrFail($id);
        $questions = $exam->question;
        foreach($questions as $q){
            $q->question;
        }
        
        return view('exam.training.take',compact('exam','questions','subheader'));
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
        //
    }
}
