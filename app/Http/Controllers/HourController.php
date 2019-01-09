<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Payroll;
use App\Employee;
use App\Hour;
use App\Location;
use App\Datetime;
use App\Tip;
use App\Shift;
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
        $subheader = "Hours";
        if($r->has('year')){
            $year = $r->year;
        } else {
            $year = now()->year;
        }
        $dates = \App\Helpers\PayrollPeriods::dates($year);
        $location = $r->location;
        $date = $r->dateRange;
        $stats = ['scheduled' => 0, 'effective' => 0];
        $index = false;
        

       if(isset($location) && isset($date)){
            $dt = Carbon::createFromFormat('Y-m-d',$date)->startOfDay();
            $start = $date;
            $end = $dt->addDays(14)->toDateString();
            $hours = Hour::where('location_id',$location)->where('start',$date)->get();
            $scheduledEmployees = Shift::select('employee_id')->where('location_id',$location)->whereBetween('start',[$start,$end])->distinct()->get();

            $stats['effective'] = Hour::where('location_id',$location)->where('start',$date)->sum('wk1Effective');
            $stats['effective'] += Hour::where('location_id',$location)->where('start',$date)->sum('wk2Effective');
            $stats['scheduled'] = Hour::where('location_id',$location)->where('start',$date)->sum('wk1Scheduled');
            $stats['scheduled'] += Hour::where('location_id',$location)->where('start',$date)->sum('wk2Scheduled');
            $stats['effectiveCash'] = Hour::where('location_id',$location)->where('start',$date)->sum('wk1EffectiveCash');
            $stats['effectiveCash'] += Hour::where('location_id',$location)->where('start',$date)->sum('wk2EffectiveCash');
            $stats['scheduledCash'] = Hour::where('location_id',$location)->where('start',$date)->sum('wk1ScheduledCash');
            $stats['scheduledCash'] += Hour::where('location_id',$location)->where('start',$date)->sum('wk2ScheduledCash');
            $index = true;

       } else {
        $hours = [];
        $scheduledEmployees = 0;
        $index = false;
       }
     
   
        return view('hour.index',compact('index','locations','dates','hours','scheduledEmployees','stats','subheader','location','date','year'));
   
    }
    public function compute()
    {
       
        $locations = Location::pluck('name','id');
        $locations->put('all','All locations');
        $subheader = 'Hours';
        $dates = \App\Helpers\PayrollPeriods::dates(now()->year);
        return view('hour.compute',compact('dates','locations','subheader'));
    }
    public function computeEngine(Request $r)
    {
        if(Gate::allows('calculate-hours')){
            if($r->location == 'all'){ // all locations
                Hour::where('start',$r->startDate)->delete();

                $locations = Location::get();
                $rows = 0;
                foreach($locations as $location)
                {
                    $rows += Hour::computeHours($r->startDate,$location->id);
                    $tip = Tip::tipHours($r->startDate,$location->id);  
                }

                
            } else { // single location
                Hour::where('start',$r->startDate)->where('location_id',$r->location)->delete();
                $rows = Hour::computeHours($r->startDate,$r->location);  
                $tip = Tip::tipHours($r->startDate,$r->location);
            }
            
            return $rows;
        } else {
            return 'Operation not allowed';
        }
     
    }

    
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
    public function scheduledHourReport(){
        $subheader = 'Schedule Report';
        $locations = Location::NonOffice()->pluck('name','id');
        $dates = Datetime::pastYears(2);
        $frequencies = Datetime::payFrequency();
       // // $dates = Datetime::periods(2017);
       //  $location = $r->location;
       //  $date = $r->dateRange;
       //  $stats = ['scheduled' => 0, 'effective' => 0];

      
     
       
        return view('report.store.schedule.index',compact('locations','dates','subheader','frequencies'));
    }
    public function scheduledHourReportData(Request $r){
        $location = Location::find($r->location);
        switch($r->frequency){
            case 'week': $frequency = 'Weekly'; break;
            case 'bi': $frequency = 'Biweekly'; break;
            case 'm': $frequency = 'Monthly'; break;
            default: $frequency = 'Biweekly'; break;
        }
        $result = array();

        if(isset($location) && isset($r->year)){
           // $result = 
        

            $periods = DB::table('payroll_period')->where('year',$r->year)->get();

            foreach($periods as $p)
            {
                $p->frontCount = 0;
                $p->frontHour = 0;
                $p->backCount = 0;
                $p->backHour = 0;
                $p->noodleCount = 0;
                $p->noodleHour = 0;
                $p->totalEffective = 0;

                $hours = Hour::where('location_id',$r->location)->where('start',$p->start)->where('end',$p->end)->get();
                foreach($hours as $h)
                {
                   
                    if($h->employee){
                        
                        $p->totalEffective += $h->wk1Effective + $h->wk2Effective;

                        switch($h->employee->job->type){
                        case 'server':
                        $p->frontHour += $h->wk1Scheduled + $h->wk2Scheduled;
                        $p->frontCount += 1;

                        break;
                        case 'cook':
                        $p->backHour += $h->wk1Scheduled + $h->wk2Scheduled;
                        $p->backCount += 1;
                            break;
                         case 'pantry':
                        $p->backHour += $h->wk1Scheduled + $h->wk2Scheduled;
                        $p->backCount += 1;
                            break;
                         case 'chef':
                        $p->backHour += $h->wk1Scheduled + $h->wk2Scheduled;
                        $p->backCount += 1;
                            break;
                        case 'noodle':
                        $p->noodleHour += $h->wk1Scheduled + $h->wk2Scheduled;
                        $p->noodleCount += 1;
                            break;
                        }
                    }
                    
                }

            }

       }



        return view('report.store.schedule.data',compact('location','frequency','periods'));
    }
}
