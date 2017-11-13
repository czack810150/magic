<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payroll;
use App\Employee;
use App\Hour;
use App\Location;
use App\Datetime;
use App\Tip;
use Carbon\Carbon;

class HourController extends Controller
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
    public function index(Request $r)
    {
        $locations = Location::Store()->pluck('name','id');
        $dates = Datetime::periods(Carbon::now()->year);

        $location = $r->location;
        $date = $r->dateRange;
       
       if(!empty($location) && !empty($date)){
            $hours = Hour::where('location_id',$location)->where('start',$date)->get();
       } else {
        $hours = [];
       }
     
       
        return view('hour.index',compact('locations','dates','hours'));
    }
    public function compute()
    {
        $dates = Datetime::periods(Carbon::now()->year);
        return view('hour.compute',compact('dates'));
    }
    public function computeEngine(Request $r)
    {
     $rows = Hour::hoursEngine($r->startDate);  
     $tip = Tip::tipHours($r->startDate);
     return $rows;
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
    public function breakdown(Request $r){
        return Hour::breakdown($r->employee,$r->location,$r->startDate);
    }
}
