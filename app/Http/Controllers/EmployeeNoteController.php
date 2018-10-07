<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\Employee_note;

class EmployeeNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employee = Employee::find($request->employee);
        $user = Auth::user();
        $notes = Employee_note::where('employee_id',$request->employee)->get();
        foreach($notes as $n){
               $n->author = Employee::find($n->edited_by)->cName;
        }
        return view('employee/profile/notes/index',compact('notes','employee','user'));
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
        $note = new Employee_note;
        $note->edited_by = Auth::user()->authorization->employee_id;
        $note->visibility = $request->visibility;
        $note->note = $request->note;
        $note->employee_id =  $request->employee;
        $note->save();
        return $request->employee;
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
       return Employee_note::find($id);
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
        $note  = Employee_note::find($id);
        $note->note = $request->note;
        if($request->visibility){
            $note->visibility = $request->visibility;
        }
        $note->edited_by = Auth::user()->authorization->employee_id;
        $note->save();
        return $note->employee_id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note  = Employee_note::find($id);
        Employee_note::destroy($id);
        return $note->employee_id;
    }
}
