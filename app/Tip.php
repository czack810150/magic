<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hour;
use App\Location;
use Carbon\Carbon;
use App\Payroll_tip;

class Tip extends Model
{
	protected $fillable = ['start','end','location_id','hours','tips','hourlyTip'];

    public static function tipHours($startDate)
    {
    	$startDate = Carbon::createFromFormat('Y-m-d',$startDate);
    	//return $startDate->toDateString();
    	$start = $startDate->toDateString();
    	$end = $startDate->addDays(13)->toDateString();
    	$hours = Hour::where('start',$start)->get();
    	
 
    	$locations = array();

    	foreach($hours as $h)
    	{
    		
    		
    	
    		if( $h->location_id != 0 && !isset($locations[$h->location_id]) )
    		{
    			$locations[$h->location_id] = new TipHours($h->location_id,$start,$end);
    				
    			if(!$h->employee->job->trial){
    			$locations[$h->location_id]->tipHours += $h->wk1Effective + $h->wk2Effective;
    			} 
    		} else {
    			if($h->location_id != 0 && !$h->employee->job->trial){
    			$locations[$h->location_id]->tipHours += $h->wk1Effective + $h->wk2Effective;
    			}
    		}

    	}
    	self::saveLocationTipHours($locations);

    	return $locations;
    }

    public static function saveLocationTipHours($locations){
    	foreach($locations as $location){

    		$tip = Payroll_tip::where('start',$location->start)->where('location_id',$location->location)->first();
    		if($tip){
    			$tip->hours = $location->tipHours;
    			$tip->save();

    		} else {
    			Payroll_tip::create([
    			'start' => $location->start,
    			'end' => $location->end,
    			'location_id' => $location->location,
    			'hours' => $location->tipHours,
    		]);
    		}

    		
    	}
    }
}

class TipHours
{
	public $location;
	public $tipHours = 0;
	public $start;
	public $end;
	public function __construct($location,$start,$end){
		$this->location = $location;
		$this->start = $start;
		$this->end = $end;
	}
}
