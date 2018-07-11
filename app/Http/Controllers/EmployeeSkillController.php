<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Employee;
use App\Location;
use App\Job;
use App\Skill;

class EmployeeSkillController extends Controller
{
    public function index()
    {
        $subheader = 'Employee Skills';
        if(Gate::allows('view-allEmployee')){
        $employees = Employee::activeEmployee()->with('skill.skill')->get();
        $skills = Skill::orderBy('skill_category_id')->get();
           

        $locations = Location::pluck('name','id');
        $employeeLocations = Location::pluck('name','id');
        $locations[-1] = 'All Locations';
        $status = array(
            'active' => 'Active staffs only',
            'vacation' => 'On vacation only',
            'terminated' => 'Terminated staffs',
        ); 
        $groups = array(
            '%' => 'All Roles',
            'trial' => '试用期',
            'employee' => 'Employee',
            'supervisor' => 'Supervisor',
            'manager' => 'Manager',
        );
        $jobs = Job::where('trial',1)->pluck('rank','id');
        return view('employee.skill.index',compact('employees','subheader','locations','status','jobs','employeeLocations','groups','skills'));

        } else if(Auth::user()->authorization->type == 'manager'){

            $employees = Employee::where('location_id',Auth::user()->authorization->employee->location_id)->get();
            $locations = Location::where('id',Auth::user()->authorization->employee->location_id)->pluck('name','id');
            $employeeLocations = Location::pluck('name','id');
            
            $status = array(
            'active' => 'Active staffs only',
            'vacation' => 'On vacation only',
            'terminated' => 'Terminated staffs',
        ); 
        $jobs = Job::where('trial',1)->pluck('rank','id');
        return view('employee.index',compact('employees','subheader','locations','status','jobs','employeeLocations'));
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
