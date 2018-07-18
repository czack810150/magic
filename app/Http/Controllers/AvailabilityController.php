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
use App\Availability;

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
       
        $availability = Availability::create([
            'employee_id' => $request->employee,
            'monFrom' => $request->availability['mon']['from'],
            'monTo' => $request->availability['mon']['to'],
            'tueFrom' => $request->availability['tue']['from'],
            'tueTo' => $request->availability['tue']['to'],
            'wedFrom' => $request->availability['wed']['from'],
            'wedTo' => $request->availability['wed']['to'],
            'thuFrom' => $request->availability['thu']['from'],
            'thuTo' => $request->availability['thu']['to'],
            'friFrom' => $request->availability['fri']['from'],
            'friTo' => $request->availability['fri']['to'],
            'satFrom' => $request->availability['sat']['from'],
            'satTo' => $request->availability['sat']['to'],
            'sunFrom' => $request->availability['sun']['from'],
            'sunTo' => $request->availability['sun']['to'],
            'hours' => $request->availability['hourLimit'],
            'holiday' => $request->availability['holiday']
        ]);
        return $availability;
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
