<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Employee;
use App\Job;
use Gate;

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
}
