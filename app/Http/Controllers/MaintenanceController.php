<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Employee;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    public function index()
    {
        if(Gate::allows('is-management')){
            return view('maintenance.index');
            if(Auth::user()->authorization->type == 'manager'){
                return view('maintenance.index');
               
            } else { 
                return view('maintenance.index');
                
            }            
            
        } else {
            //check if this is location account
            if(Auth::user()->authorization->type == 'location'){
                return redirect()->route('timeclock');
            } else 
            {
                return self::employee();
            }
        }
        
    }
     private function employee()
    {
            $employee = Employee::find(Auth::user()->authorization->employee_id);
            $promotions = $employee->promotion;
            $shifts = $employee->schedule->where('start','>=',Carbon::now()->toDateString())->sortBy('start');
            return view('dashboard.employee.home',compact('promotions','shifts'));
    }
}
