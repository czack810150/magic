<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Score_log;
use App\EmployeeReview;
use App\Employee_location;
use App\Events\EmployeeReviewSubmitted;

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
            'pass' => $request->examPassed == 'true'? true:false,
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
}
