<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Employee;
use App\Employee_trace;
use App\Location;
use App\JobPromotion;
use App\Shift;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('is-management')){

            if(Auth::user()->authorization->type == 'manager'){
                $locations = Location::where('manager_id',Auth::user()->authorization->employee_id)->get();
            } else { 
                $locations = Location::store()->get();
            }            
            
            $promotions = JobPromotion::get();

            return view('dashboard.management.home',compact('locations','promotions'));
        } else {
            $employee = Employee::find(Auth::user()->authorization->employee_id);
            $promotions = $employee->promotion;
            $shifts = $employee->schedule->where('start','>=',Carbon::now()->toDateString())->sortBy('start');
            return view('dashboard.employee.home',compact('promotions','shifts'));
        }
        
    }
}
