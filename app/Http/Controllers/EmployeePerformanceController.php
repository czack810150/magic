<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Datetime;
use App\Employee;
use App\Shift;
use Illuminate\Support\Facades\View;
use App\Score_category;
use App\Score_item;
use App\Score_log;
use Carbon\Carbon;

class EmployeePerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subheader = 'Employee Performance Evalucation';
        $locations = Location::Store()->pluck('name','id');
        $dates = Datetime::periods(Carbon::now()->year);
        return view('employee.performance.index',compact('locations','dates','subheader'));
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
        $item = Score_item::find($request->item);
        $score_log = Score_log::create(['date'=>$request->reviewDate,
            'location_id'=>$request->location,
            'employee_id'=>$request->employee,
            'score_item_id'=>$request->item,
            'value'=>$item->value,                 
        ]);
        return $item;
        
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
    public function destroy(Request $r)
    {
        return Score_log::destroy($r->logId);
    }
    public function reviewable(Request $r)
    {
        $periodStart = Carbon::createFromFormat('Y-m-d',$r->period);
        $start = $periodStart->toDateString();
        $end = $periodStart->addDays(13)->toDateString();
        $categories = Score_category::all(); 
        $employees = Employee::where('location_id',$r->location)->orderBy('job_id')->get();
        foreach($employees as $e){

            $e->score = Score_log::where('location_id',$r->location)->where('employee_id',$e->id)->
                            whereBetween('date',[$start,$end])->sum('value') + 100;
            if($e->score > 110){
                $e->score = 110;                
            }
        }
          
            return View::make('employee.performance.reviewable',compact('employees','categories'))->render();
    }
    public function employeePeriod(Request $r)
    {
        $periodStart = Carbon::createFromFormat('Y-m-d',$r->startDate);
        $start = $periodStart->toDateString();
        $end = $periodStart->addDays(13)->toDateString();
        $scoreItems = Score_log::where('employee_id',$r->employee)->where('location_id',$r->location)->whereBetween('date',[$start,$end])->orderBy('date')->get();
        $result = array();
        foreach($scoreItems as $scoreItem){
           $scoreItem->score_item;
             $scoreItem->score_item->score_category;
             $scoreItem->location;
            // $scoreItem->location = $socreItem->location->name;
            $result[] = $scoreItem;
        }
        return View::make('employee.performance.individual',compact('result'))->render();
    }
}
