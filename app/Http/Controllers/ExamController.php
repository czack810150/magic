<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question_category;
use App\Location;
use App\Question;
use App\Exam;
use App\Exam_question;

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
}
