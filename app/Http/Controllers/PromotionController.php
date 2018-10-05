<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\Payroll_config;
use Carbon\Carbon;
use App\Job;
use App\JobPromotion;
use App\Events\PromotionRequested;
use App\Events\PromotionApproved;
use App\Events\PromotionRejected;
use App\Employee_location;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subheader = 'View Promotion';
        $promotions = JobPromotion::orderBy('created_at')->get();

        return view('promotion.index',compact('promotions','subheader'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
        
    }
    public function apply()
    {
        $subheader = 'Request Promotion';
        if(Gate::allows('canBePromoted')){
         $employee = Auth::user()->authorization->employee;
         $pay = DB::table('payroll_config')->where('year',Carbon::now()->year)->first();
         $nextJob = Job::nextJob($employee->job->id);
           return view('promotion.apply',compact('nextJob','pay','employee','subheader')); 
       } else {
        return 'only store employees can be promoted in this way.';
       }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subheader = 'Promotion Request';
        $employee = Auth::user()->authorization->employee;
        // check if existing pending application
        if(!count(JobPromotion::where('employee_id',$employee->id)->where('status','pending')->get()) )
        {
             $promotion = new JobPromotion;
             $promotion->employee_id = $employee->id;
             $promotion->oldJob = $employee->job->id;
             $promotion->newJob = $request->newJob;
             $promotion->oldLocation = $employee->location_id;
             $promotion->newLocation = $employee->location_id;
             $promotion->status = 'pending';
             $promotion->comment = $request->comment;
             $promotion->save();
             event(new PromotionRequested($promotion));
             $message = 'Your promotion request has been created!';
             return view('request.success',compact('message','subheader'));  
        } else {
             $message = 'you have one active pending promotion request already.';
             return view('request.fail',compact('message','subheader'));  
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
    public function approve($id)
    {
        $subheader = 'Promotions';
        $promotion = JobPromotion::findOrFail($id);
        if($promotion->employee_id == Auth::user()->authorization->employee_id){
            return 'No authorization! You can not approve your own promotion request.';
        } else {

            $employee = Employee::findOrFail($promotion->employee_id);
            $employee->job_id = $promotion->newJob->id;
            $employee->location_id = $promotion->newLocation->id;
            $status = $employee->save();
            
            if($status){
                 $promotion->status = 'approved';
                 $promotion->modifiedBy = Auth::user()->authorization->employee_id;
                 $promotion->save();


                 if(count($employee->job_location)){
                    $employee_location_old = Employee_location::where('employee_id',$employee->id)->latest()->first();
                 $employee_location_old->end = Carbon::now()->toDateString();
                 $employee_location_old->save();
                 }
                 
                 Employee_location::create([
                    'employee_id' => $employee->id,
                    'location_id' => $employee->location_id,
                    'job_id' => $employee->job_id,
                    'start' => Carbon::now()->toDateString(),
                    'review' => Carbon::now()->addDays(180)->toDateString(),
                 ]);


            event(new PromotionApproved($promotion));     
                return self::index();
            }
            else {
                return 'saving error';
            }
           
        }
    }
    public function deny($id)
    {
        $subheader = 'Promotions';
        $promotion = JobPromotion::findOrFail($id);
        if($promotion->employee_id == Auth::user()->authorization->employee_id){
            return 'No authorization! You can not reject your own promotion request.';
        } else {
            $promotion->status = 'rejected';
            $promotion->modifiedBy = Auth::user()->authorization->employee_id;
            $promotion->save();
            event(new PromotionRejected($promotion)); 
            return self::index();
        }
    }
    
}
