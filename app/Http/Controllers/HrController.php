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
            $locations = Location::store()->pluck('name','id');
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

            $data['newHires'] = Employee::whereYear('hired',now()->year)->get()->count();
            $data['terminations'] = Employee::whereYear('termination',now()->year)->get()->count();
            $data['newHiresPrevious'] = Employee::whereYear('hired',now()->subYear()->year)->get()->count();
            $data['terminationsPrevious'] = Employee::whereYear('termination',now()->subYear()->year)->get()->count();

            return view('hr.index',compact('data','locations','subheader'));
        } else {
            return view('system.deny',compact('subheader'));
        }
        
    }

  
    public function team()
    {
        if(Gate::allows('view-hr')){
            $subheader = 'Team';
            if(auth()->user()->authorization->type == 'manager'){
                $locations = Location::where('id',Auth::user()->authorization->employee->location_id)->pluck('name','id');
            } else {
              $locations = Location::pluck('name','id');
                
            }
            $currentTeam = Location::find(Auth::user()->authorization->employee->location_id);
           
            return view('hr.team.index',compact('currentTeam','data','locations','subheader'));
        } else {
            return view('system.deny',compact('subheader'));
        }
    }
    public function teamChart(Request $r)
    {
        $team = collect();
        $currentTeam = Location::find($r->location);
        $manager = $currentTeam->manager;
        $manager->alias = $manager->employee_profile->alias;
        $manager->title = $manager->job->rank;
        $manager->link = "/staff/profile/$manager->id/show";
        $manager->img = "/storage/".$manager->employee_profile->img;
        $manager->gender = $manager->employee_profile->sex;
        $employees = collect();
        foreach($currentTeam->employee->sortBy('job_id') as $e){
            if($currentTeam->manager_id != $e->id){
                if($e->status != 'terminated'){
                    $e->title = $e->job->rank;
                    $e->link = "/staff/profile/$e->id/show"; 
                    if($e->employee_profile){
                        $e->gender = $e->employee_profile->sex;
                        $e->img = "/storage/".$e->employee_profile->img;
                        $e->alias = $e->employee_profile->alias;
                    }
                    $employees->push($e);
               }
            }
        }

        $team->put('manager',$manager);
        $team->put('team',$currentTeam);
        $team->put('employees',$employees);
        return $team;
        // return view('hr.team.chart',compact('currentTeam'));
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
    public function locationBreakdown(Request $r)
    {   
        if($r->location == 999){
            $data['positionBreakdown'] = Employee::jobBreakdown(null);
        } else {
            $data['positionBreakdown'] = Employee::jobBreakdown($r->location);
        }
        
        return view('hr.location.breakdown',compact('data'));
    }
    public function hires_terminations(Request $request)
    {
        if($request->location === 'all'){
            $data['newHires'] = Employee::whereYear('hired',$request->year)->get()->count();
            $data['terminations'] = Employee::whereYear('termination',$request->year)->get()->count();
            $data['newHiresPrevious'] = Employee::whereYear('hired',$request->year-1)->get()->count();
            $data['terminationsPrevious'] = Employee::whereYear('termination',$request->year-1)->get()->count();
        } else {
            $data['newHires'] = Employee::where('location_id',$request->location)->whereYear('hired',$request->year)->get()->count();
            $data['terminations'] = Employee::where('location_id',$request->location)->whereYear('termination',$request->year)->get()->count();
            $data['newHiresPrevious'] = Employee::where('location_id',$request->location)->whereYear('hired',$request->year-1)->get()->count();
            $data['terminationsPrevious'] = Employee::where('location_id',$request->location)->whereYear('termination',$request->year-1)->get()->count();
        }
        return [
            'success' => true,
            'data' => $data,
        ];
        
    }
}
