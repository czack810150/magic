<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Employee;
use App\Location;
use App\Hour;
use App\Clock;
use Carbon\Carbon;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function attendance()
    {
        if(Gate::allows('manage-managers')){
            $subheader = 'Managers\' Attendance';
            $currentWeek = Carbon::now();
            $start = $currentWeek->startOfWeek()->toDateString();
            $end = $currentWeek->endOfWeek()->toDateString();

            $periodStart = Carbon::createFromFormat('Y-m-d',$start);
            $periodEnd = Carbon::createFromFormat('Y-m-d',$end);
            //dd($start);

            $locations = Location::store()->get();
            foreach($locations as $location){
                $location->manager->totalClocked = Hour::clockedHour($location->manager->id,$location->id,$start,$end);
                $location->manager->attendance = Hour::openings($location->manager->id,$location->id,$start,$end);
            }

            return view('manager.attendance.index',compact('subheader','locations','currentWeek','periodStart','periodEnd'));
        } else {
            return 'Not authorized';
        }
    }

    public function attendanceByDateRange(Request $r)
    {
        if(Gate::allows('manage-managers')){
    

            $periodStart = $r->from;
            $periodEnd = $r->to;

            $locations = Location::store()->get();
            foreach($locations as $location){
                $location->manager->totalClocked = Hour::clockedHour($location->manager->id,$location->id,$periodStart,$periodEnd);
                $location->manager->attendance = Hour::openings($location->manager->id,$location->id,$periodStart,$periodEnd);
            }

            return view('manager.attendance.attendanceAjax',compact('locations','periodStart','periodEnd'));
        } else {
            return 'Not authorized';
        }
    }
    public function attendanceDetail(Request $r){
         if(Gate::allows('manage-managers')){
            
            $clocks = Clock::where('employee_id',$r->employee)->whereDate('clockIn','>=',$r->from)->whereDate('clockIn','<=',$r->to)->orderBy('clockIn')->get();
            return view('manager.attendance.detail',compact('clocks'));
        } else {
            return 'Not authorized';
        }
    }
}
