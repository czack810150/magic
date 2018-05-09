<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Employee;
use App\Job;
use App\Team;
use Gate;
use Auth;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $subheader = 'Teams';
        if(Gate::allows('view-hr')){
            $teams = Team::get();
            return view('hr.team.taskforce.index',compact('teams','subheader'));
        } else {
            return view('system.deny',compact('subheader'));
        }
    }


    public function create()
    {
        $subheader = 'Teams';
        if(Gate::allows('create-team')){
            $teams = Team::pluck('name','id');
            $locations = Location::pluck('name','id');
            return view('hr.team.taskforce.create',compact('teams','locations','subheader'));
        } else {
            return view('system.deny',compact('subheader'));
        }
    }

   
    public function store(Request $r)
    {
        $team = Team::create([
            'name' => $r->name,
            'employee_id' => $r->leader,
            'team_id' => $r->superior,
            'description' => $r->description
        ]);
        return $team;
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
