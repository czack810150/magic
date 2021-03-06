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
       
        $availability = Availability::where('employee_id',$request->employee)->first();
        
        if($availability){
            $availability->update([
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

        } else {
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
        }

        
        return 'success';
    }

    public function employeeTab($id)
    {
        $a = Availability::where('employee_id',$id)->first();
        return view('employee.profile.availability.index',compact('a'));
    }

    public function my()
    {
        $subheader = "Availability";
        $hours = Datetime::hours(60);
        $availability = Availability::firstOrCreate([
            'employee_id' => Auth::user()->authorization->employee_id
        ],[
            'monFrom' => '00:00:00',
            'monTo' => '00:00:00',
            'tueFrom' => '00:00:00',
            'tueTo' => '00:00:00',
            'wedFrom' => '00:00:00',
            'wedTo' => '00:00:00',
            'thuFrom' => '00:00:00',
            'thuTo' => '00:00:00',
            'friFrom' => '00:00:00',
            'friTo' => '00:00:00',
            'satFrom' => '00:00:00',
            'satTo' => '00:00:00',
            'sunFrom' => '00:00:00',
            'sunTo' => '00:00:00',
            'hours' => '44+',
            'holiday' => '1',
        ]);
        return view('employeeUser.availability.index',compact('subheader','hours','availability'));
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
