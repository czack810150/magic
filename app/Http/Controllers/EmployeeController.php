<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\Employee_profile;
use App\Employee_background;
use App\Employee_location;
use App\User;

use App\Location;
use App\Job;
use App\Authorization;
use Carbon\Carbon;



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
        $employeeLocations = Location::pluck('name','id');
        $locations[-1] = 'All Locations';
        $status = array(
            'active' => 'Active staffs only',
            'vacation' => 'On vacation only',
            'terminated' => 'Terminated staffs',
        ); 
        $jobs = Job::where('trial',1)->pluck('rank','id');
        return view('employee.index',compact('employees','subheader','locations','status','jobs','employeeLocations'));
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
        $validatedData = $request->validate([
                  'email' => 'required|string|email|max:255|unique:users',
                  'firstName' => 'required|string|max:64',
                  'lastName' =>'required|string|max:64',
                  'cName' => 'string|max:32',
                  'job' => 'required|numeric',
                  'employeeLocation' => 'required|numeric',
                  'employeeRole' => 'required|numeric',
                  'employeeNumber' => 'required|string|max:32|unique:employees',
                  'hireDate' => 'required|date_format:Y-m-d'
                ]);
       $employee = Employee::create([
            'employeeNumber' => $request->employeeNumber,
            'email' => $request->email,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'cName' => $request->cName,
            'location_id' => $request->employeeLocation,
            'job_id' => 10,
            'hired' => $request->hireDate,
       ]);
       $employee_location = Employee_location::create([
        'employee_id' => $employee->id,
        'location_id' => $request->employeeLocation,
        'job_id' => $employee->job_id,
        'start' => $request->hireDate,
       ]);
       $employee_background = Employee_background::create([
        'employee_id' => $employee->id,
       ]);
        return redirect('/staff/profile/'.$employee->id.'/show');
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
        if(Gate::allows('view-employee',$staff)){
            return view('employee/profile/index',compact('staff','subheader'));
        } else {
            return 'Not authorized';
        }
        
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
            $profile->alias = $r->alias;
            $profile->save(); 
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
                $profile->alias = $r->alias;
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
                $background->status_expiry = $r->status_expiry;
                $background->english = $r->english;
                $background->chinese = $r->chinese;
                $background->cantonese = $r->cantonese;
                $background->french = $r->french;
                $background->save();
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            $background->hometown = $r->hometown;
            $background->canada_status = $r->canada_status;
            $background->status_expiry = $r->status_expiry;
            $background->english = $r->english;
            $background->chinese = $r->chinese;
            $background->cantonese = $r->cantonese;
            $background->french = $r->french;
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
        if(Gate::allows('update-employment')){
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
        'employee'=>'Employee',
        ];
        }
        return view('employee.profile.employment.edit',compact('employee','user','jobs','types','locations'));
        } else {
            return 'No authorization!';
        }
    }
    public function updateEmployment(Request $r)
    {
      
        $profile = Employee_profile::where('employee_id',$r->employee)->first();
        if(is_null($profile)){

            try {
            $profile = new Employee_profile;
            $profile->employee_id = $r->employee;
            $profile->sin = $r->sin;
            $profile->save(); 
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            $profile->sin = $r->sin;
            $profile->save();
        }
        $userAuth = Authorization::where('employee_id',$r->employee)->first();
        if(!is_null($userAuth)){
            $userAuth->type = $r->type;
            $userAuth->save();
        }
       
        $employee = Employee::find($r->employee);
        $employee->job_id = $r->job;
        $employee->employeeNumber = $r->employeeNumber;
        $employee->hired = $r->hired;
        if(!empty($r->termination)){
            $employee->termination = $r->termination;
        } else {
            $employee->termination = null;
        }
        $employee->location_id = $r->location;
        $employee->save();

        $employee_location_old = Employee_location::where('employee_id',$r->employee)->latest()->first();
        $employee_location_old->end = Carbon::now()->toDateString();
        $employee_location_old->save();
        Employee_location::create([
            'employee_id' => $r->employee,
            'location_id' => $r->location,
            'job_id' => $r->job,
            'start' => Carbon::now()->toDateString(),
        ]);

        return 1;
    }
    public function compensation(Request $r)
    {
        $basicRate = DB::table('payroll_config')->where('year',Carbon::now()->year)->first();
        $employee = Employee::find($r->employee);
        return view('employee.profile.compensation.index',compact('basicRate','employee'));
    }
    public function account(Request $r)
    {
        $employee = Employee::find($r->employee);
        $authorization = Authorization::where('employee_id',$r->employee)->first();
        return view('employee.profile.account.index',compact('authorization','employee'));
    }

     public function editAccount($id)
     {
       
        $employee = Employee::find($id);
        $authorization = Authorization::where('employee_id',$id)->first();
        $types = array(
            'Employee' => 2,
            'Manager' => 20
        );
        return view('employee.profile.account.edit',compact('employee','authorization','types'));
     }
     public function updateAccount($id, Request $r)
     {
        $authorization = Authorization::where('employee_id',$id)->first();
        
        if( !is_null($authorization) ){
            $user = $authorization->user;

            if($user->email == $r->email){
                $validatedData = $r->validate([
                     'password' => 'required|string|min:6|confirmed', 
                ]);
            } else {
                $validatedData = $r->validate([
                  'email' => 'required|string|email|max:255|unique:users',
                  'password' => 'required|string|min:6|confirmed', 
                ]);
                $user->email = $r->email;
            }
            $username = strstr($r->username,'@',true);
            $user->name = $username;
            $user->password = bcrypt($r->password);
            $user->save();
                return 'updated';
            
        } else {
           return $this->createAccount($id,$r);
        }  
     }

     private function createAccount($id, Request $r){
            $validatedData = $r->validate([
                  'email' => 'required|string|email|max:255|unique:users',
                  'password' => 'required|string|min:6|confirmed', 
                ]);
            $employee = Employee::find($id);


            $username = strstr($r->username,'@',true);
            $newUser = User::create([
            'name' => $username,
            'email' => $r->email,
            'password' => bcrypt($r->password),
        ]);
        $newAuthorization = new Authorization;
        $newAuthorization->employee_id= $id;
        $newAuthorization->location_id = $employee->location_id;
        $newAuthorization->user_id = $newUser->id;
        $newAuthorization->type = 'employee';
        $newAuthorization->level = 2;
        $newAuthorization->save();
            return 'created';

     }
     public function training(Request $r)
     {
        $employee = Employee::find($r->employee);
        $authorization = Authorization::where('employee_id',$r->employee)->first();

        $logs = $employee->training;
        foreach($logs as $log){
            $log->trainer_name = $log->trainer->cName;
            $log->stage = $log->item->stage;
            $log->itemName = $log->item->name;
            switch($log->item->sub_category){
                case 1: $log->category = '前厅';break;
                case 2: $log->category = '后厨';break;
                case 3: $log->category = '洗碗';break;
            }
           
        }


        return view('employee.profile.training.index',compact('authorization','employee','logs'));
     }

     public function background($id)
     {
        $employee = Employee::find($id);
        return view('employee.profile.background.index',compact('employee'));
     }
     public function editEducation($id)
     {
        $employee = Employee::find($id);
        $educations = array(
            'below highschoo' => 'Below Highschool',
            'highschool' => 'Highschool',
            'college' => 'College',
            'university' => 'University',
            'graduate' => 'Graduate Degrees',
        );
        return view('employee.profile.background.editEducation',compact('employee','educations'));
     }
     public function updateEducation($id, Request $r)
     {
         $background = Employee_background::where('employee_id',$id)->first();
        if(is_null($background)){
            try {
                $background = new Employee_background;
                $background->employee_id = $id;
                $background->education = $r->education;
                $background->school = $r->school;
                $background->major = $r->major;
                $background->student = $r->student;
                $background->interest = $r->interest;
                $background->save();
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
                $background->employee_id = $id;
                $background->education = $r->education;
                $background->school = $r->school;
                $background->major = $r->major;
                $background->student = $r->student;
                $background->interest = $r->interest;
                $background->save();
        }
        return 'updated';  
     }
     public function editWorkHistory($id)
     {
        $employee = Employee::find($id);
        return view('employee.profile.background.editWorkHistory',compact('employee'));
     }      
      public function updateWorkHistory($id, Request $r)
     {
         $background = Employee_background::where('employee_id',$id)->first();
        if(is_null($background)){
            try {
                $background = new Employee_background;
                $background->employee_id = $id;
                $background->company_job = $r->job;
                $background->company = $r->company;
                $background->company_city = $r->location;
                $background->company_start = $r->start;
                $background->company_end = $r->end;
                $background->company_quit = $r->quit_reason;
                $background->company_supervisor = $r->supervisor;
                $background->company_contact = $r->contact;
                $background->company_check = $r->check;
                $background->check_reason = $r->check_reason;
                $background->save();
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
                $background->company_job = $r->job;
                $background->company = $r->company;
                $background->company_city = $r->location;
                $background->company_start = $r->start;
                $background->company_end = $r->end;
                $background->company_quit = $r->quit_reason;
                $background->company_supervisor = $r->supervisor;
                $background->company_contact = $r->contact;
                $background->company_check = $r->check;
                $background->check_reason = $r->check_reason;
                $background->save();
        }
        return 'updated';  
     }
      


}
