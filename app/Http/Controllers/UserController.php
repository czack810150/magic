<?php

namespace App\Http\Controllers;
use App\User;
use App\Location;
use App\Authorization;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subheader = 'User Admin';
        $users = User::all();
        return view('users.index',compact('users','subheader'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subheader = 'User Admin';
        $locations = Location::pluck('name','id');

      
        $types = array(
            'applicant' => 'Applicant',
            'location' => 'Location',
            'staff' => 'Staff',
            'employee' => 'Employee',
            'manager' => 'Manager',
            'dm' => 'District Manager',
            'accounting' => 'Accountant',
            'hr' => 'Human Resource',
            'gm' => 'General Manager',
            'admin' => 'Admin',
        );
        return view('users.create',compact('subheader','locations','types'));
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
            'username' => 'string|required|unique:users,name|min:5|max:255',
            'email' => 'string|email|required|unique:users|max:255',
            'password' => 'string|required|confirmed|min:5|max:255',
            'locationSelect' => 'required|numeric',
            'employee' => 'nullable|numeric',
            'typeSelect' =>'required'
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $newAuthorization = new Authorization;
        $newAuthorization->user_id = $user->id;
        $newAuthorization->type = $request->typeSelect;
        $newAuthorization->location_id = $request->locationSelect;
        $newAuthorization->level = $this->authLevel($request->typeSelect);
        if($request->typeSelect != 'location'){
            $newAuthorization->employee_id = $request->employee;
        }
        $newAuthorization->save();
        return redirect('/users');
    }

    private function authLevel($authorization)
    {
        switch($authorization){
             case 'applicant':
                $level = 0;
                break;
            case 'location':
                $level = 2;
                break; 
            case 'staff':
                $level = 3;
                break;
            case 'employee': 
                $level = 10;
                break;
            case 'manager':
                $level = 20;
                break;
            case 'dm':
                $level = 30;
                break;    
            case 'accounting':
                $level = 40;
                break;
            case 'hr':
                $level = 50;
                break;
            case 'gm':
                $level = 60;
                break;
            case 'admin':
                $level = 99;
                break;
            default: $level = 0;
        }
        return $level;
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
