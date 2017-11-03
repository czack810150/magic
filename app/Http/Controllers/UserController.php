<?php

namespace App\Http\Controllers;
use App\User;
use App\Location;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
            'accounting' => 'Accoutant',
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
        dd($request);
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
