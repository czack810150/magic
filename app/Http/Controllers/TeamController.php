<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Employee;
use App\Job;
use App\Team;
use App\TeamMember;
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
        $leader = TeamMember::create([
            'team_id' => $team->id,
            'employee_id' => $r->leader
        ]);
        return redirect('team/taskforce');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subheader = 'Teams';
        if(Gate::allows('view-hr')){
        $team = Team::findOrFail($id);
        $locations = Location::pluck('name','id');
        $teams = Team::where('id','!=',$id)->pluck('name','id');
       
        return view('hr.team.taskforce.show',compact('team','teams','locations','subheader'));
        } else {
            return view('system.deny',compact('subheader'));
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
        $team = Team::find($id);
        $team->team_id = $request->superior;
        $team->save();

        if(count($request->members)){
        foreach($request->members as $m)
        {
           if($team->employee_id != $m['id']){
             TeamMember::destroy($m['member_id']);
           } 
        }
        }
        foreach($team->teamMember as $m)
        {
            $m->name = $m->employee->name;
            $m->location = $m->employee->location->name;
            $m->position = $m->employee->job->rank;
            $m->sex = $m->employee->employee_profile->sex;
            $m->img = '/storage/'.$m->employee->employee_profile->img;
            $m->alias = $m->employee->employee_profile->alias;
            $m->link = '/staff/profile/'.$m->employee_id.'/show';
        }

        return $team->teamMember;
    }

    public function destroy($id)
    {
        $team = Team::destroy($id);
        $members = TeamMember::where('team_id',$id)->delete();
        $teams = Team::where('team_id',$id)->update(['team_id'=>null]);
        return redirect('team/taskforce');
    }
    public function addMember(Request $r){
        
       
        foreach($r->members as $m)
        {
            if(!count(TeamMember::where('team_id',$r->team)->where('employee_id',$m['id'])->get()) )
            {
                TeamMember::create([
                    'team_id' => $r->team,
                    'employee_id' => $m['id']
                ]);
            }
           
           
        }
        $team = Team::find($r->team);
        foreach($team->teamMember as $m)
        {
            $m->name = $m->employee->name;
            $m->location = $m->employee->location->name;
            $m->position = $m->employee->job->rank;
            $m->sex = $m->employee->employee_profile->sex;
            $m->img = '/storage/'.$m->employee->employee_profile->img;
            $m->alias = $m->employee->employee_profile->alias;
            $m->link = '/staff/profile/'.$m->employee_id.'/show';
        }

        return $team->teamMember;
    }
}
