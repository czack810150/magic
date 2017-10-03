<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Payroll;
use App\Employee;
use App\Hour;
use App\Location;
use App\Datetime;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payroll.index');
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
        //
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
    }
     public function basic()
    {
        $locations = Location::Store()->pluck('name','id');
        $employees = Employee::where('location_id',1)->get();
        $dates = Datetime::periods(2017);
        foreach($employees as $e){


            $e->wk1 = Hour::effectiveHour($e->id,1,'2017-09-11','2017-09-17');
            $e->wk2 = Hour::effectiveHour($e->id,1,'2017-09-18','2017-09-24');

            $e->nightHour = $e->wk1['nightHours'] + $e->wk2['nightHours'];
      
            // $e->grossPay = Payroll::twoWeekGrossPay($e->wk1['hours'],$e->wk2['hours'],2017);
            // $e->basicPay = Payroll::basicPay($e->wk1['hours'],$e->wk2['hours'],2017);

             $e->magicNoodlePay = Payroll::magicNoodlePay(2017,$e->wk1['hours'],$e->wk2['hours'],
                                        $e->job_location()->first()->job->rate/100,
                                        $e->job_location()->first()->job->tip,
                                        10,
                                        $e->nightHour,
                                        1,
                                        0
                                        );
        }
       
        return view('payroll.basic.index',compact('employees','locations','dates'));
    }
    public function fetch(Request $r){

        $employees = Employee::where('location_id',$r->location)->get();
        $startDate = Carbon::createFromFormat('Y-m-d',$r->startDate,'America/Toronto')->startOfDay();
        $wk1Start =  $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();

        foreach($employees as $e){
            $e->wk1 = Hour::effectiveHour($e->id,$r->location,$wk1Start,$wk1End);
            $e->wk2 = Hour::effectiveHour($e->id,$r->location,$wk2Start,$wk2End);
            $e->nightHour = $e->wk1['nightHours'] + $e->wk2['nightHours'];
    
            $e->magicNoodlePay = Payroll::magicNoodlePay(2017,$e->wk1['hours'],$e->wk2['hours'],
                                        $e->job_location()->first()->job->rate/100,
                                        $e->job_location()->first()->job->tip,
                                        10,
                                        $e->nightHour,
                                        1,
                                        0
                                        );
        }

        return view('payroll.basic.table',compact('employees'));
    }
}
