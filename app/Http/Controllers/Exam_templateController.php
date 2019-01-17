<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question_category;
use App\Location;
use App\Employee;
use App\Question;
use App\Answer;
use App\Exam;
use App\Exam_question;
use App\Exam_template;
use App\Exam_template_question;
use App\Authorization;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExamCreatedMail;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;


class Exam_templateController extends Controller
{
   
    public function index()
    {
        $subheader = 'Employee Training';
        $templates = Exam_template::get();
        $locations = Location::pluck('name','id');
        $employees = Employee::where('location_id',Auth::user()->authorization->location_id)->pluck('cName','id');
        return view('exam.template.index',compact('subheader','templates','locations','employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subheader = 'Employee Training';
        $exam = new Exam;
        $exam->employee_id = $request->selectedEmployee;
        $exam->name = $request->examName;
        $exam->access = str_random(64);
        $exam->created_by = Auth::user()->authorization->employee_id;
        $exam->save();

        $template = Exam_template::find($request->templateId);
        $template->used += 1;
        $template->save();
        $questions = $template->question;
        foreach($questions as $q){
            $question = Exam_question::create(['question_id'=>$q->question_id]);
            $exam->question()->save($question);
        }
           $group = Authorization::group(['admin','hr','dm']);
           $manager = $exam->employee->location->manager;
           $group->push($manager);
           Mail::to($exam->employee)->cc($group)->send(new ExamCreatedMail($exam));
        return view('exam.template.success',compact('subheader'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $template = Exam_template::findOrFail($id);
        return view('exam.template.template',compact('template'));
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
        $template = Exam_template::destroy($id);
        return redirect('/exam_templates');
    }
}
