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

class EmployeeSkillController extends Controller
{
    public function index()
    {
        $subheader = 'Employee Skills';


        if(Gate::allows('view-allEmployee')){
            $employees = Employee::activeEmployee()->with('skill.skill')->get();
            $locations = Location::pluck('name','id');
            $locations[-1] = 'All Locations';

        } else if(Auth::user()->authorization->type == 'manager'){

            $employees = Employee::where('location_id',Auth::user()->authorization->employee->location_id)->with('skill.skill')->get();
            $locations = Location::where('id',Auth::user()->authorization->employee->location_id)->pluck('name','id');
            
        }

        $skills = Skill::orderBy('skill_category_id')->get();
        $employeeLocations = Location::pluck('name','id');
        
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
        return view('employee.skill.index',compact('employees','subheader','locations','status','employeeLocations','groups','skills'));
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

    
    public function store(Request $request)
    {
        if(count(EmployeeSkill::where('employee_id',$request->employee)->where('skill_id',$request->skill)->get()))
        {
            return [
                'status' => 'failed',
                'message' => 'Skill already exists'
            ];
        } else {
            $skill = EmployeeSkill::create([
                'employee_id' => $request->employee,
                'skill_id' => $request->skill,
                'level' => $request->level,
                'assigned_by' => $request->assignedBy,
            ]);
            if($skill){
                return [
                'status' => 'success',
                'message' => 'Skill has been saved',
            ];
            } else {
                return [
                'status' => 'failed',
                'message' => 'Skill saving error'
            ];
            }
            
        }
        
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
        $skill = EmployeeSkill::find($id);
        $skill->level = $request->level;
        $skill->save();
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return EmployeeSkill::destroy($id);
        
    }
    public function getSkillsByEmployee(Request $r)
    {
        $employee = Employee::with('skill.skill')->find($r->employee);
        return $employee->skill;
    }
}
