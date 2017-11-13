<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payroll_tip;
use Carbon\Carbon;

class PayrollTipController extends Controller
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
        //
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
        $dt = Carbon::createFromFormat('Y-m-d',$request->startDate);

        $already = Payroll_tip::where('start',$request->startDate)->where('location_id',$request->location)->first();
     
        if($already){
            $already->hourlyTip = $request->tip * 100;
            $already->save();
        } else {

        $t = new Payroll_tip;
        $t->start = $request->startDate;
        $t->end = $dt->addDays(13)->toDateString();
        $t->location_id = $request->location;
        $t->hourlyTip = $request->tip * 100;
        $t->save();
        }
        return $request->tip;
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tip = Payroll_tip::findOrFail($id);
        return view('store.tip.show',compact('tip'));
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
        $tip = Payroll_tip::findOrFail($id);
        $tip->hourlyTip = $request->hourlyTip * 100;
         $tip->tips = $request->tips * 100;
          $tip->hours = $request->hours;
        $tip->save();
        return redirect('/tips');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Payroll_tip::destroy($id);
        return redirect('/tips');
    }
}
