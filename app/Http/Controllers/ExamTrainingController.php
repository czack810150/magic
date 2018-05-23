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


class ExamTrainingController extends Controller
{
    public function index()
    {
        $subheader = 'Training';

        $exams = ExamTraining::get()->count();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->cats;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
