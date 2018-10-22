<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\Score_log;
use App\EmployeeReview;
use App\Employee_location;
use App\Events\EmployeeReviewSubmitted;
use App\Events\EmployeeReviewVerified;


class EmployeeReviewController extends Controller
{
   
    public function index()
    {
        $subheader = 'Employee Review';
        return view('employee/review/index',compact('subheader'));
    }

    public function create(Employee $employee)
    {
        $subheader = 'Employee Review';
        return view('employee/review/create',compact('employee','subheader'));
    }
   
    public function store(Request $request)
    {
        
        $employee = Employee::find($request->employee);
        if(count($employee->exam)){
            $exam = $employee->exam->last()->id;
        } else {
            $exam = 'null';
        }
        
        $review = EmployeeReview::create([
            'employee_id' => $request->employee,
            'manager_id' => $request->manager,
            'reviewed' => true,
            'exam_id' => $exam,
            'pass' => $request->examPassed == 1? true:false,
            'reviewDate' => $request->reviewDate,
            'nextReview' => $request->nextReview,
            'manager_score' => $request->managerScore,
            'self_score' => $request->selfScore,
            'performance' => $request->performance,
            'hr_score' => 0,
            'org_score' => 0,
            'result' => $request->pass == 'true'? true:false,
            'description' => $request->resultDescription,
            'manager_note' => $request->managerNote,
            'self_note' => $request->selfNote
        ]);
        if($review){
            $employee_location_old = Employee_location::where('employee_id',$request->employee)->latest()->first();
            $employee_location_old->end = $request->reviewDate;
            $employee_location_old->save();
            Employee_location::create([
            'employee_id' => $request->employee,
            'location_id' => $employee_location_old->location_id,
            'job_id' => $employee_location_old->job_id,
            'start' => $request->reviewDate,
            'review' => $request->nextReview,
        ]);

            event(new EmployeeReviewSubmitted($review));
            return ['status'=>'success','message'=>'Employee Review Saved.'];
        } else {
            return ['status'=>'danger','message'=>'Employee Review Failed.'];
        }

    }

    
    public function show(EmployeeReview $review)
    {
        $user = Auth::user()->authorization->employee_id;
        if($user == $review->employee_id || in_array(Auth::user()->authorization->type,['hr','dm','admin','manager'])){
            $subheader = 'Employee Review';
            $employee = $review->employee;
            return view('employee/review/view',compact('employee','subheader','review'));
        } else {
            return 'not authorized.';
        }
        
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

    public function update(Request $request)
    {
        $review = EmployeeReview::find($request->review);
        $review->verified = true;
        if($review->save()){
            event(new EmployeeReviewVerified($review));
           return ['status'=>'success','message'=>$review->employee->name."的考核结果已被批准！"]; 
       } else {
        return ['status'=>'danger','message'=>"Error!"]; 
       }
        
    }


    public function updateReview(Request $request)
    {
        $review = EmployeeReview::find($request->id);
        $review->pass = $request->examPassed == 1? true:false;
        $review->reviewDate = $request->reviewDate;
        $review->nextReview = $request->nextReview;
        $review->manager_score = $request->managerScore;
        $review->self_score = $request->selfScore;
        $review->performance = $request->performance;
           
        $review->result = $request->pass == 1? true:false;
        $review->description = $request->resultDescription;
        $review->manager_note = $request->managerNote;
        $review->self_note = $request->selfNote;
        $review->save();
        return ['status'=>'success','message'=>'Employee Review Updated.'];
    }
    public function getPerformance(Request $r){
        // return $r->reviewDate;
        $performance =  Score_log::reviewScore($r->employee,$r->reviewDate);
        $score = round($performance['score']*.7,0);
        return $score;
    }
    public function getAllReviews()
    {
        return EmployeeReview::with('employee.location')->with('manager')->get();
    }
    public function myReview()
    {
        $subheader = 'My Performance Reviews';
        $employee = Auth::user()->authorization->employee;
        $reviews = $employee->review->where('verified',true);
        
        return view('employeeUser/myReviews',compact('employee','subheader','reviews'));
        
    }
    public function employeeReviews(Request $r)
    {
        $employee = Employee::with('review')->findOrFail($r->employee);
        return view('employee.profile.review.index',compact('employee'));
    }
}
