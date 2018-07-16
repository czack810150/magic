<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
use App\Employee;
use App\Location;
use App\Job;
use App\Skill;
use App\EmployeeSkill;
use App\Datetime;

class AvailabilityController extends Controller
{
    public function index()
    {
        $subheader = 'Employee Availability';


        if(Gate::allows('view-allEmployee')){
            
            $locations = Location::pluck('name','id');
            $locations[-1] = 'All Locations';

        } else if(Auth::user()->authorization->type == 'manager'){

           
            $locations = Location::where('id',Auth::user()->authorization->employee->location_id)->pluck('name','id');
            
        }
        $hours = Datetime::hours(60);
        $skills = Skill::orderBy('skill_category_id')->get();
       
        
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
        return view('employee.availability.index',compact('subheader','hours','locations','status','groups','skills'));
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
}
