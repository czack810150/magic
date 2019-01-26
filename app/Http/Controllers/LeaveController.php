<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\Location;
use App\Leave;
use App\LeaveType;
use App\EmployeePending;

use App\Events\LeaveRequested;
use App\Events\LeaveApproved;
use App\Events\LeaveRejected;

class LeaveController extends Controller
{
  
    public function index()
    {
        $subheader = 'Time off requests';
        $leaves = Leave::where('employee_id',Auth::user()->authorization->employee_id)->get(); // own leaves
        if(Auth::user()->authorization->type == 'employee'){
            return view('leave.index',compact('subheader','leaves'));
        } else if(Auth::user()->authorization->type == 'manager') {
            $employeeLeaves = Leave::where('location_id',Auth::user()->authorization->location_id)->where('employee_id','!=',Auth::user()->authorization->employee_id)->orderBy('from','desc')->paginate(15);
            return view('leave.index',compact('subheader','leaves','employeeLeaves'));
        } else if(in_array(Auth::user()->authorization->type,['hr','dm','accounting','gm','admin']))
        {
            $employeeLeaves = Leave::where('employee_id','!=',Auth::user()->authorization->employee_id)->orderBy('from','desc')->paginate(15);
            return view('leave.index',compact('subheader','leaves','employeeLeaves'));
        }
    }

  
    public function create()
    {
        $subheader = 'Time off requests';
        $types = LeaveType::pluck('name','id');
        if(Auth::user()->authorization->type == 'manager')
        {
            $employees = Employee::where('location_id',Auth::user()->authorization->employee->location_id)->activeAndVacationEmployees()->pluck('cName','id');
            return view('leave.create',compact('subheader','employees','types'));
        } else {
            return view('leave.create',compact('subheader','types'));
        }   
    }

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
        event(new LeaveRequested($leave));
        return redirect('leave');

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $subheader = 'Time off requests';
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
        $subheader = 'Time off requests';
        $leave = Leave::findOrFail($id);
        if($leave->employee_id == Auth::user()->authorization->employee_id){
            return 'No authorization! You can not approve your own leave request.';
        } else {
            $leave->status = 'approved';
            $leave->approvedBy = Auth::user()->authorization->employee_id;
            $leave->save();

            if($leave->type->id == 2){
                $status = 'vacation';
            } else {
                $status = $leave->type->name;
            }
            // add to EmployeePending
            $pending = EmployeePending::create([
                'employee_id' => $leave->employee_id,
                'status' => $status,
                'start' => $leave->from,
                'end' => $leave->to
            ]);
           

            event(new LeaveApproved($leave));
            return redirect('leave');
        }
    }
    public function deny($id)
    {
        $subheader = 'Time off requests';
        $leave = Leave::findOrFail($id);
        if($leave->employee_id == Auth::user()->authorization->employee_id){
            return 'No authorization! You can not reject your own leave request.';
        } else {
            $leave->status = 'rejected';
            $leave->approvedBy = null;
            $leave->save();
            event(new LeaveRejected($leave));
            return redirect('leave');
        }
    }
     public function pending($id)
    {
        $subheader = 'Time off requests';
        $leave = Leave::findOrFail($id);
      
            $leave->status = 'pending';
            $leave->approvedBy = null;
            $leave->save();
            return redirect('leave');
    
    }
}
