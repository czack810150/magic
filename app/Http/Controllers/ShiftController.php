<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shift.shift.index');
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
    public function apiCreate(Request $request)
    {
        $shift = new Shift;
        $shift->location_id = $request->input('location');  
        $shift->employee_id = $request->input('employee_id');
        $shift->role_id = $request->input('role');
        $shift->start = $request->input('start_time');
        $shift->end = $request->input('end_time');        
        $shift->published = 1;
        $shift->comment = $request->input('note');
        $shift->created_by = 1;
        $shift->save();      
        return $shift->start;
    }
    public function getShift(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $shifts = Shift::whereDate('start','>=',$start)
                    ->whereDate('end','<',$end)
                   
                    ->get();
        return view('shift/shift/shiftList',compact('shifts'));
    }
}
