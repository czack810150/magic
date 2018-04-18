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

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      
        $employee = Auth::user()->authorization->employee;
        $promotion = new JobPromotion;
        $promotion->employee_id = $employee->id;
        $promotion->oldJob = $employee->job->id;
        $promotion->newJob = $request->newJob;
        $promotion->oldLocation = $employee->location_id;
        $promotion->newLocation = $employee->location_id;
        $promotion->status = 'pending';
        $promotion->comment = $request->comment;
        $promotion->save();

        return $promotion;
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
