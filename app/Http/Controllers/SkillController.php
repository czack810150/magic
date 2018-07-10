<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Training_item;
use App\Training_log;
use App\Skill;
use App\Skill_category;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('configure-app')){
            $subheader = 'Skills';
            $skills = Skill::get();
            return view('skill.index',compact('skills','subheader'));
        } else {
            return view('request.fail')->with('message','You are not authorized to view this content.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::allows('configure-app')){
            $subheader = 'Skills';
            $categories = Skill_category::pluck('cName','id');
            return view('skill.create',compact('subheader','categories'));
        } else {
            return view('request.fail')->with('message','You are not authorized to view this content.');
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
        if(Gate::allows('configure-app')){
        $skill = new Skill;
        $skill->skill_category_id = $request->category;
        $skill->name = $request->name;
        $skill->cName = $request->cName;
        $skill->description = $request->description;
        if($skill->save()){
            return redirect('skills');
        } else {
            return view('request.fail')->with('message','Operation failed.');
        }
        } else {
            return view('request.fail')->with('message','You are not authorized to view this content.');
        }
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
        if(Gate::allows('configure-app')){
          $skill = Skill::findOrFail($id);
          $categories = Skill_category::pluck('cName','id');
          return view('skill.edit',compact('subheader','skill','categories'));
        
        } else {
            return view('request.fail')->with('message','You are not authorized to view this content.');
        }
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
        if(Gate::allows('configure-app')){
        $skill = Skill::findOrFail($id);
        if( $skill->name != $request->name)
        $skill->name = $request->name;
        if( $skill->cName != $request->cName)
        $skill->cName = $request->cName;
        if( $skill->description != $request->description)
        $skill->description = $request->description;

        if( $skill->skill_category_id != $request->category)
            $skill->skill_category_id = $request->category;

        $skill->save();
        return redirect('skills');
        } else {
            return view('request.fail')->with('message','You are not authorized to perform this operation.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::allows('configure-app')){
          Skill::destroy($id);
          return redirect('skills');
        
        } else {
            return view('request.fail')->with('message','You are not authorized to view this content.');
        }
    }
    public function getSkillByCategory($id)
    {
        $skills = Training_item::where('sub_category',$id)->pluck('name','id');
        return view('training.skills.list',compact('skills'));
    }
    public function assignSkill(Request $r)
    {

        $skill = Training_log::create([
            'employee_id' => $r->employee,
            'trainer_id' => $r->trainer,
            'item_id' => $r->skill,
            'date_trained' => $r->date,
        ]);
        $skill->item;
        return $skill;
    }
}
