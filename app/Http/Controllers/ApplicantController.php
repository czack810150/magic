<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Job;
use DB;
use Carbon\Carbon;
class ApplicantController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}

    public function index()
    {
        $subheader = 'Human Resources';
        $employeeLocations = Location::pluck('name','id');
        $jobs = Job::where('trial',1)->pluck('rank','id');
        $status = [
            'applied' => 'Applied',
            'reviewed' => 'Reviewed',
            'phoned' => 'Phone Screened',
            'interviewed' => 'Interviewed',
            'offered' => 'Job Offered',
            'rejected' => 'Rejected',
           // 'hired' => 'Hired'
        ];
        if(auth()->user()->authorization->type == 'manager'){
            $applicants = DB::connection('applicants')->table('applicants')->where('applicant_status','<>','hired')->where('location',auth()->user()->authorization->location_id)->latest()->get();
        } else {
            $applicants = DB::connection('applicants')->table('applicants')->where('applicant_status','<>','hired')->latest()->get();
        }
        
        foreach($applicants as $a){
            $a->location = Location::where('id',$a->location)->first()->name;
            $a->job = Job::where('id',$a->role)->first()->rank;
            $a->created_at = Carbon::parse($a->created_at,'UTC')->timezone('America/Toronto')->toDateTimeString();
        }



        return view('hr.applicants.index',compact('applicants','subheader','employeeLocations','jobs','status'));
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
        $applicant->availability = DB::connection('applicants')->table('availabilities')->where('applicant_id',$id)->first();
        $applicant->location = Location::find($applicant->location);
        $applicant->job = Job::find($applicant->role);
        return view('hr/applicants/applicant',compact('applicant')); 
    }
      public function fetch($id)
    {
        $applicant =  DB::connection('applicants')->table('applicants')->where('id',$id)->first();
        $result['id'] = $applicant->id;
        $result['location'] = $applicant->location;
        $result['role'] = $applicant->role;
        $result['cName'] = $applicant->cName;   
        $result['hireDate'] = Carbon::now()->toDateString();
        return $result;
    }
    public function getNote($id)
    {
        return DB::connection('applicants')->table('applicants')->find($id)->note;   
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
    public function update(Request $request)
    {
        
        $status = DB::connection('applicants')->table('applicants')->where('id',$request->applicant)->update(['applicant_status'=>$request->applicantStatus]);
        if($status){
            return 'success';
        } else {
            return 'failed';
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
         
         DB::connection('applicants')->table('availabilities')->where('applicant_id',$id)->delete();
         DB::connection('applicants')->table('pastworks')->where('applicant_id',$id)->delete();
         DB::connection('applicants')->table('schools')->where('applicant_id',$id)->delete();
         DB::connection('applicants')->table('positions')->where('applicant_id',$id)->delete();
         $status = DB::connection('applicants')->table('applicants')->where('id',$id)->delete();
        if($status){
            return redirect('/applicant');
        } else {
            return 'failed to remove this applicant';
        }
    }
    public function saveNote(Request $r)
    {
        $status = DB::connection('applicants')->table('applicants')->where('id',$r->applicant)->update(['note'=>$r->note]);
        if($status){
            return ['status'=>'success','message'=>'Note has been save. '];
        } else {
            return ['status'=>'failed','message'=>'Failed.'];
        }
    }
}
