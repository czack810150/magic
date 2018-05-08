<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Employee;
use App\Job;
use Gate;
use Auth;

class HrController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}
    public function index()
    {
        $subheader = 'Human Resources';
        if(Gate::allows('view-hr')){
            $locations = Location::pluck('name','id');
            $locations['999'] = 'All';
            $data['activeEmployees'] = Employee::activeEmployee()->count();
            $data['terminatedEmployees'] = Employee::terminatedEmployees()->count();
            $data['positionBreakdown'] = Employee::jobBreakdown(null);
            $data['totalEmployees'] = Employee::activeAndVacationEmployees()->count();
            $data['locationEmployees'] = Employee::locationEmployeesCount();

            $data['types']['server'] = Job::typeCount('server',null);
            $data['types']['cook'] = Job::typeCount('cook',null);
            $data['types']['noodle'] = Job::typeCount('noodle',null);
            $data['types']['manager'] = Job::typeCount('management',null);
            $data['types']['kitchen'] = Job::typeCount('pantry',null) + Job::typeCount('chef',null) + Job::typeCount('driver',null);
            $data['types']['office'] = Job::typeCount('office',null) + Job::typeCount('hq',null);
            return view('hr.index',compact('data','locations','subheader'));
        } else {
            return view('system.deny',compact('subheader'));
        }
        
    }

  
    public function team()
    {
        if(Gate::allows('view-hr')){
            $subheader = 'Team';
            $locations = Location::pluck('name','id');
            $currentTeam = Location::find(Auth::user()->authorization->employee->location_id);
            
            // $data['activeEmployees'] = Employee::activeEmployee()->count();
            // $data['terminatedEmployees'] = Employee::terminatedEmployees()->count();
            // $data['positionBreakdown'] = Employee::jobBreakdown(null);
            // $data['totalEmployees'] = Employee::activeAndVacationEmployees()->count();
            // $data['locationEmployees'] = Employee::locationEmployeesCount();

            // $data['types']['server'] = Job::typeCount('server',null);
            // $data['types']['cook'] = Job::typeCount('cook',null);
            // $data['types']['noodle'] = Job::typeCount('noodle',null);
            // $data['types']['manager'] = Job::typeCount('management',null);
            // $data['types']['kitchen'] = Job::typeCount('pantry',null) + Job::typeCount('chef',null) + Job::typeCount('driver',null);
            // $data['types']['office'] = Job::typeCount('office',null) + Job::typeCount('hq',null);
            return view('hr.team.index',compact('currentTeam','data','locations','subheader'));
        } else {
            return view('system.deny',compact('subheader'));
        }
    }
    public function teamChart(Request $r)
    {
        $currentTeam = Location::find($r->location);

        return view('hr.team.chart',compact('currentTeam'));
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
    public function destroy($id)
    {
        //
    }
}
