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
use App\Sale;
use Carbon\Carbon;


class HomeController extends Controller
{

    public function index()
    {
        if(Gate::allows('is-management')){

            if(Auth::user()->authorization->type == 'manager'){
                return self::storeManager();
            } else { 
                return self::management();
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
    private function storeManager()
    {
        $locations = Location::where('manager_id',Auth::user()->authorization->employee_id)->get();
        return view('dashboard.management.home',compact('locations','promotions'));
    }
    private function management()
    {
        $dt = Carbon::now();
        $promotions = JobPromotion::get();
        $locations = Location::store()->get();
        $data['monthlyTotal'] = Sale::whereYear('from',$dt->year)->whereMonth('from',$dt->month)->where('location_id','!=',0)->sum('amount');

        // $dt2 = Carbon::now()->startOfMonth();
        // while($dt2->toDateString() != $dt->toDateString())
        // {
        //     $data['dailyTotal'] = array();
        //     $sale = Sale::whereDate('from',$dt2->toDateString())->where('location_id','!=',0)->sum('amount');
        //     array_push($data['dailyTotal'],$sale);
        //     $dt2->addDay();
        // }

        return view('dashboard.management.home',compact('locations','promotions','data'));
    }
    private function employee()
    {
            $employee = Employee::find(Auth::user()->authorization->employee_id);
            $promotions = $employee->promotion;
            $shifts = $employee->schedule->where('start','>=',Carbon::now()->toDateString())->sortBy('start');
            return view('dashboard.employee.home',compact('promotions','shifts'));
    }
}
