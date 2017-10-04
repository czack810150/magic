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

define('YEAR',Carbon::now()->year);

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
        $dates = Datetime::periods(YEAR);
     
       
        return view('payroll.basic.index',compact('locations','dates'));
    }
    public function fetch(Request $r){

        $employees = Employee::where('location_id',$r->location)->get();
        $startDate = Carbon::createFromFormat('Y-m-d',$r->startDate,'America/Toronto')->startOfDay();
        $wk1Start =  $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();

        $sum = array(
            'regularHour' => 0,
            'overtimeHour' => 0,
            'gross' => 0,
            'EI' => 0,
            'CPP' => 0,
            'fedTax' => 0,
            'pTax' => 0,
            'cheque' => 0,
            'meal' => 0,
            'nightHour' => 0,
            'nightPay' => 0,
            'bonus' => 0,
            'variable' => 0,
            'total' => 0,
        );

        foreach($employees as $e){
            
            $e->wk1 = Hour::effectiveHour($e->id,$r->location,$wk1Start,$wk1End);
            $e->wk2 = Hour::effectiveHour($e->id,$r->location,$wk2Start,$wk2End);
            $e->nightHour = $e->wk1['nightHours'] + $e->wk2['nightHours'];
    
            $e->magicNoodlePay = Payroll::magicNoodlePay(YEAR,$e->wk1['hours'],$e->wk2['hours'],
                                        $e->job_location()->first()->job->rate/100,
                                        $e->job_location()->first()->job->tip,
                                        10,
                                        $e->nightHour,
                                        1,
                                        0
                                        );
            if($e->job_location()->first()->job->hour){
            $sum['regularHour'] += $e->magicNoodlePay->totalHours;
            $sum['overtimeHour'] += $e->magicNoodlePay->grossPay->overtime1 + $e->magicNoodlePay->grossPay->overtime2;
            $sum['gross'] += $e->magicNoodlePay->grossPay->total;
            $sum['EI'] += $e->magicNoodlePay->basicPay->EI;
            $sum['CPP'] += $e->magicNoodlePay->basicPay->CPP;
            $sum['fedTax'] += $e->magicNoodlePay->basicPay->federalTax;
            $sum['pTax'] += $e->magicNoodlePay->basicPay->provincialTax;
            $sum['cheque'] += $e->magicNoodlePay->basicPay->net;
            $sum['meal'] += round($e->magicNoodlePay->totalHours * $e->magicNoodlePay->variablePay->mealRate,2);
            $sum['nightHour'] += $e->magicNoodlePay->variablePay->nightHours;
            $sum['nightPay'] += $e->magicNoodlePay->variablePay->nightHours * $e->magicNoodlePay->variablePay->nightRate;
            $sum['bonus'] += $e->magicNoodlePay->variablePay->bonus;
            $sum['variable'] += $e->magicNoodlePay->variablePay->total;
            $sum['total'] += $e->magicNoodlePay->netPay;
            }
        }

        return view('payroll.basic.table',compact('employees','sum'));
    }

    public function employeeYear(Request $request)
    {
        $employee = Employee::findOrFail($request->employee);
        $payrolls = Payroll::employeePayrollYear($request->year,$request->employee);
       // sdd($payrolls);
        return view('payroll/employee/year',compact('payrolls','employee'));
    }
}
