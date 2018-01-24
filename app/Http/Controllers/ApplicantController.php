<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Job;
use DB;
class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subheader = 'Human Resources';
        $applicants = DB::connection('applicants')->table('applicants')->get();
        foreach($applicants as $a){
            $a->location = Location::where('id',$a->location)->first()->name;
            $a->job = Job::where('id',$a->role)->first()->rank;
        }
        return view('hr.applicants.index',compact('applicants','subheader'));
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
        $applicant = DB::connection('applicants')->table('applicants')->where('id',$id)->first();
        $applicant->education = DB::connection('applicants')->table('schools')->where('applicant_id',$id)->first();
        $applicant->pastwork = DB::connection('applicants')->table('pastworks')->where('applicant_id',$id)->first();
        $applicant->location = Location::find($applicant->location);
        $applicant->job = Job::find($applicant->role);
        return view('hr/applicants/applicant',compact('applicant')); 
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
