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
use App\Payroll_log;
use App\Payroll_tip;

define('YEAR',Carbon::now()->year);

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
        $deletedRows = Payroll_log::where('startDate',$id)->delete();
        return $deletedRows;

    }
     public function basic()
    {
        $subheader = "Money";
        $locations = Location::pluck('name','id');
        // $dates = Datetime::periods(0); // all years
        $dates = Datetime::periods(YEAR);
        return view('payroll.basic.index',compact('locations','dates','subheader'));
    }
    public function fetch(Request $r){
        $dt = Carbon::createFromFormat('Y-m-d',$r->startDate);
        $logs = Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->get();
        
        $config = DB::table('payroll_config')->where('year',$dt->year)->first();
        $hourlyTip = Payroll_tip::where('start',$r->startDate)->where('location_id',$r->location)->first();
        if($hourlyTip){
            $hourlyTip = $hourlyTip->hourlyTip;
        } else {
            $hourlyTip = 0;
        }

        $sum = array(
            'startDate' => $r->startDate,
            'nightRate' => $config->nightRate,
            'basicRate' => $config->minimumPay/100,
            'mealRate' => $config->mealRate,
            'hourlyTip' => $hourlyTip,
            'totalHour' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('week1') + Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('week2'),

            'overtimeHour' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('ot1') +Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('ot2'),
            'gross' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('grossIncome'),
            'EI' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('EI'),
            'CPP' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('CPP'),
            'fedTax' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('federalTax'),
            'pTax' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('provincialTax'),
            'cheque' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('cheque'),
            'nightHour' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('nightHours'),
            'bonus' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('bonus'),
            'variable' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('variablePay'),
            'total' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('totalPay'),
            'employees' => sizeof($logs),
            'cashPay' => Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->sum('cashPay'),
            );
        return view('payroll.basic.table',compact('logs','sum'));
      
        
    }

    public function employeeYear(Request $request)
    {
        $employee = Employee::findOrFail($request->employee);
        $payrolls = Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->get();
        $sum = array(
            'regular' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('week1') + Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('week2'),

            'overtime' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('ot1') +Payroll_log::where('employee_id',$request->employee)->sum('ot2'),
            'regularPay' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('regularPay'),
            'overtimePay' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('overtimePay'),
            'premiumPay' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('premiumPay'),
            'holidayPay' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('holidayPay'),
            'grossIncome' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('grossIncome'),
            'EI' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('EI'),
            'CPP' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('CPP'),
            'federalTax' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('federalTax'),
            'provincialTax' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('provincialTax'),
            'cheque' => Payroll_log::whereYear('startDate',$request->year)->where('employee_id',$request->employee)->sum('cheque'),
        );
       // sdd($payrolls);
        return view('payroll/employee/year',compact('payrolls','employee','sum'));
    }
    public function employee(){
         $locations = Location::Store()->pluck('name','id');
        return view('payroll.employee.index')->withLocations($locations);
    }
    public function compute(){
        $dates = Datetime::periods(YEAR);
        $locations = Location::pluck('name','id');
        $locations->put('all','All locations');
        $subheader = 'Payroll';
        return view('payroll.compute.index',compact('dates','locations','subheader'));
    }
    public function computePayroll(Request $r){
        $subheader = 'Payroll';
        $validatedData = $r->validate([
            'dateRange' => 'required',
            'forLocation' => 'required',
        ]);
        
        $deletedRows = Payroll_log::where('startDate',$r->dateRange)->where('location_id',$r->forLocation)->delete();

        if($r->forLocation){
            $message = Payroll::payrollCompute($r->dateRange,$r->forLocation);  //stores
        } else {
            $message = Payroll::payrollComputeKitchen($r->dateRange,$r->forLocation); // central kitchen
        }
    
        return view('payroll.compute.result',compact('message','subheader'));
  
    }
    public function paystubs(){
        $locations = Location::pluck('name','id');
        $dates = Datetime::periods(YEAR);
        return view('payroll.paystubs.index',compact('locations','dates'));
    }
    public function paystubsData(Request $r){
        $dt = Carbon::createFromFormat('Y-m-d',$r->startDate);

        $logs = Payroll_log::where('startDate',$r->startDate)->where('location_id',$r->location)->get();
        $config = DB::table('payroll_config')->where('year',$dt->year)->first();
        $hourlyTip = Payroll_tip::where('start',$r->startDate)->where('location_id',$r->location)->first();
        if($hourlyTip){
            $hourlyTip = $hourlyTip->hourlyTip;
        } else {
            $hourlyTip = 0;
        }


        
        return view('payroll.paystubs.stubs',compact('logs'));
    }
    public function chequeNumber(Request $r)
    {
        $payLog = Payroll_log::find($r->payrollLog);
        $payLog->chequeNumber = $r->chequeNumber;
        $payLog->save();
    }
}
