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
use App\Sale_total;
use App\Item;
use App\ItemCategory;
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
        $dt = Carbon::now();
        $promotions = JobPromotion::get();
        $data['magicBeefs'] = Sale::whereYear('from',$dt->year)->whereMonth('from',$dt->month)->where('location_id','!=',0)->where('itemCode','S01001')->sum('qty');
        $data['monthlySales'] = Sale_total::whereYear('date',$dt->year)->whereMonth('date',$dt->month)->where('location_id',-1)->sum('total');
        $data['preMonthlySales'] = Sale_total::whereYear('date',$dt->year)->whereMonth('date',$dt->copy()->subMonth()->month)->where('location_id',-1)->sum('total');
      
        $items = Item::menuItems()->get();
        $categories = ItemCategory::get();
        return view('dashboard.management.home',compact('locations','promotions','data','items','categories'));
    }
    private function management()
    {
        $dt = Carbon::now();
        $promotions = JobPromotion::get();
        $locations = Location::store()->get();
         $data['magicBeefs'] = Sale::whereYear('from',$dt->year)->whereMonth('from',$dt->month)->where('location_id','!=',0)->where('itemCode','S01001')->sum('qty');
        $data['monthlySales'] = Sale_total::whereYear('date',$dt->year)->whereMonth('date',$dt->month)->where('location_id',-1)->sum('total');
        $data['preMonthlySales'] = Sale_total::whereYear('date',$dt->year)->whereMonth('date',$dt->copy()->subMonth()->month)->where('location_id',-1)->sum('total');
        
        $items = Item::menuItems()->get();
        $categories = ItemCategory::get();
        

        return view('dashboard.management.home',compact('locations','promotions','data','items','categories'));
    }
    private function employee()
    {
            $employee = Employee::find(Auth::user()->authorization->employee_id);
            $promotions = $employee->promotion;
            $shifts = $employee->schedule->where('start','>=',Carbon::now()->toDateString())->sortBy('start');
            return view('dashboard.employee.home',compact('promotions','shifts'));
    }
}
