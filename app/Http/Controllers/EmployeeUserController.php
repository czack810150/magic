<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Location;
use App\Datetime;
use App\Payroll_log;
use App\Hour;
use App\Clock;
use App\Shift;
use Carbon\Carbon;

class EmployeeUserController extends Controller
{
    public function payroll()
    {
    	$subheader = "Money";
    	$currentYear = Carbon::now()->year;
        $employee = Auth::user()->authorization->employee;
        $dates = array();
        $serviceYear = Carbon::createFromFormat('Y-m-d H:i:s',$employee->hired);
        while($serviceYear->year <= $currentYear){
        	$dates[$serviceYear->year] = $serviceYear->year;
        	$serviceYear->addYear();
        }

        $logs = Payroll_log::whereYear('startDate',$currentYear)->where('employee_id',$employee->id)->orderBy('startDate','desc')->get();
       
        return view('employeeUser.payroll.index',compact('logs','dates','currentYear','subheader'));
    }
    public function paystubs(){
        $subheader = "Money";
        $currentYear = Carbon::now()->year;
        $employee = Auth::user()->authorization->employee;
        $dates = array();
        $serviceYear = Carbon::createFromFormat('Y-m-d H:i:s',$employee->hired);
        while($serviceYear->year <= $currentYear){
            $dates[$serviceYear->year] = $serviceYear->year;
            $serviceYear->addYear();
        }

        $logs = Payroll_log::whereYear('startDate',$currentYear)->where('employee_id',$employee->id)->orderBy('startDate','desc')->get();
       
        return view('employeeUser.payroll.paystubs',compact('logs','dates','currentYear','subheader'));
    }
     public function paystubsYear(Request $r){
        $logs = Payroll_log::whereYear('startDate',$r->year)->where('employee_id',Auth::user()->authorization->employee_id)->orderBy('startDate','desc')->get();
        return view('employeeUser.payroll.stubsTable',compact('logs'));
    }
    public function payrollYear(Request $r){
    	$logs = Payroll_log::whereYear('startDate',$r->year)->where('employee_id',Auth::user()->authorization->employee_id)->orderBy('startDate','desc')->get();
    	return view('employeeUser.payroll.table',compact('logs'));
    }

    public function hour()
    {
        $subheader = "Hours";
    	$currentYear = Carbon::now()->year;
        $employee = Auth::user()->authorization->employee;
        $dates = array();
        $serviceYear = Carbon::createFromFormat('Y-m-d H:i:s',$employee->hired);
        while($serviceYear->year <= $currentYear){
        	$dates[$serviceYear->year] = $serviceYear->year;
        	$serviceYear->addYear();
        }

        $logs = Hour::whereYear('start',$currentYear)->where('employee_id',$employee->id)->orderBy('start','desc')->get();
       
        return view('employeeUser.hour.index',compact('logs','dates','currentYear','subheader'));
    }
     public function hourYear(Request $r){
    	$logs = Hour::whereYear('start',$r->year)->where('employee_id',Auth::user()->authorization->employee_id)->orderBy('start','desc')->get();
    	return view('employeeUser.hour.table',compact('logs'));
    }
    public function clock()
    {
        $subheader = "Clocks";
    	$currentYear = Carbon::now()->year;
        $employee = Auth::user()->authorization->employee;
        $dates = Datetime::periods($currentYear);
       

        $logs = Hour::whereYear('start',$currentYear)->where('employee_id',$employee->id)->orderBy('start','desc')->get();
       
        return view('employeeUser.clock.index',compact('logs','dates','subheader'));
    }
     public function clockYear(Request $r){
     	$endDate = Carbon::createFromFormat('Y-m-d',$r->periodStart)->addDays(14)->toDateString();
    	$logs = Clock::where('employee_id',Auth::user()->authorization->employee_id)->whereDate('clockIn','>=',$r->periodStart)->whereDate('clockIn','<=',$endDate)->orderBy('clockIn')->get();
    	return view('employeeUser.clock.table',compact('logs'));
    }
    public function training()
    {
    	$subheader = 'Training';
    	$employee = Auth::user()->authorization->employee;
    	$logs = $employee->training;
        foreach($logs as $log){
            $log->trainer_name = $log->trainer->cName;
            $log->stage = $log->item->stage;
            $log->itemName = $log->item->name;
            switch($log->item->sub_category){
                case 1: $log->category = '前厅';break;
                case 2: $log->category = '后厨';break;
                case 3: $log->category = '洗碗';break;
            }
           
        }
        return view('employeeUser.training.index',compact('logs','subheader'));
    }
    public function scheduleHistory()
    {
        $subheader = "Schedule History";
        $currentYear = Carbon::now()->year;
        $employee = Auth::user()->authorization->employee;
        $dates = array();
        $serviceYear = Carbon::createFromFormat('Y-m-d H:i:s',$employee->hired);
        while($serviceYear->year <= $currentYear){
            $dates[$serviceYear->year] = $serviceYear->year;
            $serviceYear->addYear();
        }
        $periods = Datetime::calculatedPeriods($currentYear);

       
       
        return view('employeeUser.schedule.history.index',compact('periods','dates','currentYear','subheader'));
    }
    public function viewScheduleHistory(Request $r)
    {
        $end = Carbon::createFromFormat('Y-m-d',$r->period)->addDays(14)->toDateString();
        $shifts = Shift::where('employee_id',Auth::user()->authorization->employee_id)->
                    where('published',true)->
                    whereBetween('start',[$r->period,$end])->
                    orderBy('start')->
                    get();
        return view('employeeUser.schedule.history.table',compact('shifts'));
    }
}
