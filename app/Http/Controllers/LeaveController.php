<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\Location;
use App\Leave;
use App\LeaveType;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subheader = 'Leave Management';
        $leaves = Leave::where('employee_id',Auth::user()->authorization->employee_id)->get(); // own leaves
        if(Auth::user()->authorization->type == 'employee'){
            return view('leave.index',compact('subheader','leaves'));
        } else if(Auth::user()->authorization->type == 'manager') {
            $employeeLeaves = Location::find(Auth::user()->authorization->employee->location_id)->first()->leave;
            return view('leave.index',compact('subheader','leaves','employeeLeaves'));
        } else if(in_array(Auth::user()->authorization->type,['hr','dm','accounting','gm','admin']))
        {
            $employeeLeaves = Leave::where('employee_id','!=',Auth::user()->authorization->employee_id)->orderBy('from')->get(); // own leaves
            return view('leave.index',compact('subheader','leaves','employeeLeaves'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subheader = 'Leave Management';
        $types = LeaveType::pluck('cName','id');
        if(Auth::user()->authorization->type == 'manager')
        {
            $employees = Employee::where('location_id',Auth::user()->authorization->employee->location_id)->activeAndVacationEmployees()->pluck('cName','id');
            return view('leave.create',compact('subheader','employees','types'));
        } else {
            return view('leave.create',compact('subheader','types'));
        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = Employee::find($request->employee);
        $leave = new Leave;
        $leave->employee_id = $request->employee;
        $leave->type_id = $request->leaveType;
        $leave->from = $request->from;
        $leave->to = $request->to;
        $leave->comment = $request->comment;
        $leave->location_id = $employee->location_id;
        $leave->save();
        return redirect('leave');

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
        $subheader = 'Leave Management';
        $leave = Leave::findOrFail($id);
        if($leave->employee_id != Auth::user()->authorization->employee_id){
            return 'No authorization';
        } else {
            $leave->delete();
            return view('leave/withdrew',compact('subheader'));
        }
    }
    public function approve($id)
    {
        $subheader = 'Leave Management';
        $leave = Leave::findOrFail($id);
        if($leave->employee_id == Auth::user()->authorization->employee_id){
            return 'No authorization! You can not approve your own leave request.';
        } else {
            $leave->status = 'approved';
            $leave->approvedBy = Auth::user()->authorization->employee_id;
            $leave->save();
            return self::index();
        }
    }
    public function deny($id)
    {
        $subheader = 'Leave Management';
        $leave = Leave::findOrFail($id);
        if($leave->employee_id == Auth::user()->authorization->employee_id){
            return 'No authorization! You can not reject your own leave request.';
        } else {
            $leave->status = 'rejected';
            $leave->approved_by = null;
            $leave->save();
            return self::index();
        }
    }
     public function pending($id)
    {
        $subheader = 'Leave Management';
        $leave = Leave::findOrFail($id);
      
            $leave->status = 'pending';
            $leave->approved_by = null;
            $leave->save();
            return self::index();
    
    }
}
