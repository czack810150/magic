<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Employee;
use App\Employee_profile;

use App\Location;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $profile->sex = $r->gender;
        return $profile->sex; // below dont work;
        $profile->save();
        $employee = Employee::find($r->employee);
        $employee->firstName = $r->firstName;
        $employee->lastName = $r->lastName;
        $employee->cName = $r->cName;
       
        $employee->save();
        return 'success';
    }
}
