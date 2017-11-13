<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Employee;
use App\Employee_profile;
use App\Employee_background;
use Illuminate\Support\Facades\Auth;
use App\Location;
use App\Job;

class EmployeeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $subheader = 'Staff Directory';
        $employees = Employee::get();
        $locations = Location::pluck('name','id');
        $locations[-1] = 'All Locations';
        $status = array(
            'active' => 'Active staffs only',
            'vacation' => 'On vacation only',
            'terminated' => 'Terminated staffs',
        ); 
        return view('employee.index',compact('employees','subheader','locations','status'));
    }
     public function filterEmployees(Request $r)
    {

        if($r->location != -1){
            $employees = Employee::where('location_id',$r->location)->where('status',$r->status)->get();
        } else {
             $employees = Employee::where('status',$r->status)->get();
        }
        
        return View::make('employee.list',compact('employees'))->render();
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
        $subheader = 'Staff Profile';
        $staff = Employee::findOrFail($id);
        return view('employee/profile/index',compact('staff','subheader'));
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
    public function employeesByLocation()
    {
        $location = request('location');
        return Employee::where('location_id',$location)->get();
    }
    public function apiGet(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        return $employee;
    }
    public function location(Request $r){
        $employees = Employee::where('location_id',$r->location)->pluck('cName','id');
        return $employees;
    }
    public function editPersonal(Request $r)
    {
        $staff = Employee::find($r->employee);
        return view('employee.edit.personal',compact('staff'));
    }
    public function cancelPersonal(Request $r)
    {
        $staff = Employee::find($r->employee);
        return view('employee.edit.cancel_personal',compact('staff'));
    }
    public function updatePersonal(Request $r)
    {   
        $profile = Employee_profile::where('employee_id',$r->employee)->first();
        if(is_null($profile)){

            try {
            $profile = new Employee_profile;
            $profile->employee_id = $r->employee;
            $profile->sex = $r->gender;
            $profile->dob = $r->dob;
            $profile->married = $r->married;
            $profile->save(); 
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
                $profile->sex = $r->gender;
                $profile->dob = $r->dob;
                $profile->married = $r->married;
                $profile->save();
        }

        $background = Employee_background::where('employee_id',$r->employee)->first();
        if(is_null($background)){
            try {
                $background = new Employee_background;
                $background->employee_id = $r->employee;
                $background->hometown = $r->hometown;
                $background->canada_status = $r->canada_status;
                $background->save();
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            $background->hometown = $r->hometown;
            $background->canada_status = $r->canada_status;
            $background->save();
        }
      
        $employee = Employee::find($r->employee);
        $employee->firstName = $r->firstName;
        $employee->lastName = $r->lastName;
        $employee->cName = $r->cName;
        $employee->email = $r->email;
        $employee->save();
        return 1;
    }
     public function editContact(Request $r)
    {
        $staff = Employee::find($r->employee);
        return view('employee.edit.contact',compact('staff'));
    }
    public function cancelContact(Request $r)
    {
        $staff = Employee::find($r->employee);
        return view('employee.edit.contactCancel',compact('staff'));
    }
    public function updateContact(Request $r)
    {   
        $profile = Employee_profile::where('employee_id',$r->employee)->first();
        if(is_null($profile)){

            try {
            $profile = new Employee_profile;
            $profile->employee_id = $r->employee;
            $profile->phone = $r->phone;
            $profile->save(); 
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            $profile->phone = $r->phone;
            $profile->save();
        }

        $background = Employee_background::where('employee_id',$r->employee)->first();
        if(is_null($background)){
            try {
                $background = new Employee_background;
                $background->employee_id = $r->employee;
                $background->emergency_person = $r->emergency_person;
                $background->emergency_phone = $r->emergency_phone;
                $background->emergency_relation = $r->emergency_relation;
                $background->save();
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
                $background->emergency_person = $r->emergency_person;
                $background->emergency_phone = $r->emergency_phone;
                $background->emergency_relation = $r->emergency_relation;
                $background->save();
        }
        return 1;
    }
    public function editAddress(Request $r)
    {
        $staff = Employee::find($r->employee);
        return view('employee.edit.address',compact('staff'));
    }
    public function cancelAddress(Request $r)
    {
        $staff = Employee::find($r->employee);
        return view('employee.edit.addressCancel',compact('staff'));
    }
      public function updateAddress(Request $r)
    {   
        $profile = Employee_profile::where('employee_id',$r->employee)->first();
        if(is_null($profile)){

            try {
            $profile = new Employee_profile;
            $profile->employee_id = $r->employee;
            $profile->address = $r->address;
            $profile->city = $r->city;
            $profile->state = $r->state;
            $profile->zip = $r->zip;
            $profile->save(); 
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            $profile->address = $r->address;
            $profile->city = $r->city;
            $profile->state = $r->state;
            $profile->zip = $r->zip;
            $profile->save();
        }
        return 1;
    }

    public function employment(Request $r)
    {    
        $user = Auth::user();
        $employee = Employee::findOrFail($r->employee);
        return View::make('employee.profile.employment.index',compact('employee','user'))->render();
    }
    public function editEmployment(Request $r)
    {   
        $user = Auth::user();
        $employee = Employee::find($r->employee);
        $jobs = Job::pluck('rank','id');
        $locations = Location::pluck('name','id');

        if( in_array($user->authorization->type,['dm','hr','admin']) ) {
            $types = ['admin' => 'Admin',
        'staff' => 'Staff',
        'manager' => 'Manager',
        'employee'=>'Employee',
        'applicant' => 'Applicant',
        'gm' => 'General Mananger',
        'dm' => 'District Manager',
        'hr' => 'Human Resoureces',
        'accounting' => 'Accountant'];
        } else {
        $types = [
        'staff' => 'Staff',
        'manager' => 'Manager',
        'employee'=>'Employee',
        ];
        }
        return view('employee.profile.employment.edit',compact('employee','user','jobs','types','locations'));
    }
    public function updateEmployment(Request $r)
    {
      
        // $profile = Employee_profile::where('employee_id',$r->employee)->first();
        // if(is_null($profile)){

        //     try {
        //     $profile = new Employee_profile;
        //     $profile->employee_id = $r->employee;
        //     $profile->address = $r->address;
        //     $profile->city = $r->city;
        //     $profile->state = $r->state;
        //     $profile->zip = $r->zip;
        //     $profile->save(); 
        //     }
        //     catch (\Exception $e) {
        //         return $e->getMessage();
        //     }
        // } else {
        //     $profile->address = $r->address;
        //     $profile->city = $r->city;
        //     $profile->state = $r->state;
        //     $profile->zip = $r->zip;
        //     $profile->save();
        // }
       
        $employee = Employee::find($r->employee);
        $employee->job_id = $r->job;
        $employee->employeeNumber = $r->employeeNumber;
        $employee->hired = $r->hired;
        // if(!empty($r->termination)){
        //     $employee->termination = $r->termination;
        // } else {
        //     $employee->termination = 'NULL';
        // }
        $employee->termination = null;
        $employee->location_id = $r->location;
        $employee->save();
        return 1;
    }
}
