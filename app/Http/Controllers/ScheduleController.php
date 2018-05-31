<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Role;
use App\Duty;
use Auth;
use App\Shift;
use App\Events\ShiftsPublished;


class ScheduleController extends Controller
{   
    public function index($location = null)
    {
        $locations = Location::pluck('name','id');
        if(is_null($location)){
            $defaultLocation = Auth::user()->authorization->employee->location_id;
        } else {
            $defaultLocation = $location;
        }
        
        $otherStores = Location::Store()->where('id','!=',$defaultLocation)->pluck('name','id');
        $positions = array(
            'server' => '服务员',
            'cook' => '厨工',
            'noodle' => '拉面师',
            'dish' => '洗碗工'
        );
        $roles = Role::pluck('c_name','id');
        $duties = Duty::pluck('cName','id');
        return view('magicshift.index',compact('defaultLocation','locations','otherStores','positions','roles','duties'));
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

  
    public function publish(Request $r)
    {
        $counter = 0;
        foreach($r->events as $e){
            $shift = Shift::find($e);
            if(!$shift->published){
                $shift->published = 1;
                $shift->save();
                $counter++;
            }
        }
        event(new ShiftsPublished($r->start,$r->end,$counter));
        return $counter;
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

    public function print(Request $r)
    {
        $data = $r->all();
        return view('magicshift.print',compact('data'));
    }
}
