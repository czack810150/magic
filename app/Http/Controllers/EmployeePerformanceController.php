<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Datetime;
use App\Employee;
use App\Shift;
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
        $locations = Location::Store()->pluck('name','id');
        $dates = Datetime::periods(Carbon::now()->year);
        return view('employee.performance.index',compact('locations','dates'));
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
        //
    }
    public function reviewable(Request $r)
    {
        //dd($r);
        $start = Carbon::createFromFormat('Y-m-d',$r->startDate);
        // $employees = Shift::select('employee_id')->where('location_id',$r->location)->whereBetween('start',[$start->toDateString(),$start->addDays(13)->toDateString()])->distinct()->get();
        $employees = Employee::where('location_id',$r->location)->orderBy('job_id')->get();
        return view('employee/performance/reviewable')->with('employees',$employees);
    }
}
