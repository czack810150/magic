<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Hour;
use App\Shift;

class EmployeeStatsController extends Controller
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
        $hours = Hour::where('employee_id',$id)->get();
        $stats['chequeHour'] = $hours->sum('wk1Effective') + $hours->sum('wk2Effective');
        if(!$stats['chequeHour']){
            $stats['chequeHour'] = 1;
        }
        $stats['cashHour'] = $hours->sum('wk1EffectiveCash') + $hours->sum('wk2EffectiveCash');
        $stats['scheduledHour'] = $hours->sum('wk1Scheduled') + $hours->sum('wk2Scheduled');
        $stats['scheduledHourCash'] = $hours->sum('wk1ScheduledCash') + $hours->sum('wk2ScheduledCash');
        $stats['overtimeHour'] = $hours->sum('wk1Overtime') + $hours->sum('wk2Overtime');
        $stats['totalNightHour'] = $hours->sum('wk1Night') + $hours->sum('wk2Night')+$hours->sum('wk1NightCash') + $hours->sum('wk2NightCash');

        $shifts = Shift::where('employee_id',$id)->get();
        $stats['server'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',2)->first()->total;
        $stats['cook'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',4)->first()->total;
        $stats['noodle'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',3)->first()->total;
        $stats['topping'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',5)->first()->total;
        $stats['bbq'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',6)->first()->total;
        $stats['cold'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',7)->first()->total;
        $stats['dish'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',8)->first()->total;
        $stats['boil'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',10)->first()->total;
        $stats['pantry'] = DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))->where('employee_id',$id)->where('role_id',12)->first()->total;

        $stats['open'] = Shift::where('employee_id',$id)->where('duty_id',1)->count();
        $stats['close'] = Shift::where('employee_id',$id)->where('duty_id',2)->count();
        $stats['preClose'] = Shift::where('employee_id',$id)->where('duty_id',3)->count();
        $stats['clean'] = Shift::where('employee_id',$id)->where('duty_id',4)->count();
        $stats['deepClean'] = Shift::where('employee_id',$id)->where('duty_id',5)->count();
        $stats['training'] = Shift::where('employee_id',$id)->where('duty_id',6)->count();
        $stats['shiftManager'] = Shift::where('employee_id',$id)->where('duty_id',7)->count();

        return view('employee.stats.index',compact('stats'));
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
}
