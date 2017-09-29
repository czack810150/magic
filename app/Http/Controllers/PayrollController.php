<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Payroll;
use App\Employee;

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
        $employees = Employee::where('location_id',1)->get();
        foreach($employees as $e){



            $e->hours = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))
        ->where('start','>','2017-09-01')
        ->where('location_id',1)
        ->where('employee_id',$e->id)
        ->first();

      
             $e->grossPay = Payroll::twoWeekGrossPay(44,50,2017);
             $e->basicPay = Payroll::basicPay(44,50,2017);

             $e->magicNoodlePay = Payroll::magicNoodlePay(2017,44,55,
                                        $e->job_location()->first()->job->rate/100,
                                        $e->job_location()->first()->job->tip,
                                        10,
                                        0,
                                        1,
                                        0
                                        );
        }
       
        return view('payroll.basic.index',compact('employees'));
    }
}
