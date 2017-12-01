<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\Message_to;
use App\Employee;

class MessageToManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subheader = "I have something to say..";
        return view('message.management.index',compact('subheader'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subheader = "I have something to say..";
        return view('employeeUser.message.write',compact('subheader'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = Message::create([
            'employee_id' => Auth::user()->authorization->employee_id,
            'subject' => $request->subject,
            'body' => $request->message
        ]);
        if($request->gm != 'false'){
            $gm = Employee::where('job_id',103)->first();
            Message_to::create([
                'employee_id' => $gm->id,
                'message_id' => $message->id
            ]);
        }
        if($request->dm != 'false'){
            $dm = Employee::where('job_id',112)->first();
            Message_to::create([
                'employee_id' => $dm->id,
                'message_id' => $message->id
            ]);
        }
        return url("/message/management/sent");
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
    public function sent()
    {
        $subheader = "I have something to say..";
        return view('employeeUser.message.sent',compact('subheader'));
    }
}
