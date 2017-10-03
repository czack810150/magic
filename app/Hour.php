<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Clock;
use App\Shift;
use App\Employee;

class Hour extends Model
{
    
    public static function clockedShifts($employee,$location,$startDate,$endDate){
		$preDate = date_create($startDate);
		$previousDate = date_format(date_sub($preDate,date_interval_create_from_date_string("2 hours")),'Y-m-d H:i:s');
		$clocks = DB::table('clocks')->where("employee_id",$employee)->where("location_id",$location)->where('clockIn', '>=',$previousDate)
		        ->whereDate('clockIn','<=',$endDate)->get();
		return $clocks;
	}
    public static function scheduledHour($employee,$location,$start,$end){
    	return DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))
        ->where('location_id',$location)
        ->where('employee_id',$employee)
        ->where('start','>',$start)->whereDate('start','<=',$end)
        ->first()->total;
    }
    public static function clockedHour($employee,$location,$start,$end){
    	return DB::table('clocks')->select(DB::raw('sum(UNIX_TIMESTAMP(clockOut)-UNIX_TIMESTAMP(clockIn))/3600 as total'))
        ->where('location_id',$location)
        ->where('employee_id',$employee)
        ->where('clockIn','>',$start)->whereDate('clockIn','<=',$end)
        ->first()->total;
    }

    public static function effectiveHour($employee,$location,$start,$end)
    {
    	//config
    	$nightStart = 1;
    	$nightEnd = 6;
    	// statistics 
		$totalSeconds = 0;
		$totalLateMinutes = 0;
		$totalNightSeconds = 0;

		$shifts = Shift::where('employee_id',$employee)->where('location_id',$location)->where('start','>=',$start)->whereDate('start','<=',$end)->
    						orderBy('start')->get();

	    
    	if(count($shifts)){
		foreach($shifts as $s){
					$planedStart = date_create($s->start);
					$planedEnd = date_create($s->end);

					$shiftDate = date_format($planedStart,'Y-m-d');
					
					$clockedHours = self::clockedShifts($employee,$location,$shiftDate,$shiftDate);	

					if(count($clockedHours)){
				foreach($clockedHours as $c){
					$clockIn = date_create($c->clockIn);
					$clockOut = date_create($c->clockOut);
					
					
					// comming to work
					if(($clockIn > $planedEnd && $clockIn > $planedStart) || ($clockOut < $planedStart && $clockOut < $planedEnd) ){
						continue;
					} else {
					if($clockIn > $planedStart) { // late for work
						$effectiveStart = $clockIn;
						// $lateBegin = $clockIn->diff($planedStart)->format('%h')*60 + $clockIn->diff($planedStart)->format('%i') ;
						// if($lateBegin > $lateEffectiveMinute){ // late for work over defined late standard
						// 	$totalLateMinutes += $lateBegin;
						// }
		// 					leaving
							if($clockOut <= $planedEnd) { // left early
								$effectiveEnd = $clockOut;
							} else {
								$effectiveEnd = $planedEnd;
								// $effectiveEnd = $this->smartOut($clockOut,$planedEnd,$effectiveStart); // for now, left late, we use planed leave time
								}
					} else { // early for work
						$effectiveStart = $planedStart;
						if($clockOut <= $planedEnd) { // left early
							$effectiveEnd = $clockOut;
						}  else {
								$effectiveEnd = $planedEnd;
								 // $effectiveEnd = $this->smartOut($clockOut,$planedEnd,$effectiveStart); // for now, left late, we use planed leave time
								}
						}
				$totalSeconds += self::totalSeconds($effectiveStart,$effectiveEnd);
				$totalNightSeconds += self::nightHours($effectiveStart,$effectiveEnd,$nightStart,$nightEnd);
				} // check if current clock in is later than the current shift off time end
				}

					}
					 
		}
			$result = array(
				'seconds' => $totalSeconds,
				'hours' => round($totalSeconds/3600,2),
				//'late' => $totalLateMinutes,
				'nightSeconds' => $totalNightSeconds,
				'nightHours' => round($totalNightSeconds/3600,2),
			);
				return $result;
		
		} else {
			$result = array(
				'seconds' => 0,
				'hours' => 0,
				//'late' => $totalLateMinutes,
				'nightSeconds' => 0,
				'nightHours' => 0,
			);
				return $result;
		}					

    }

    static function totalSeconds($start,$end){
		$start = date_format($start,'U');
		$end = date_format($end,'U');
		return $end-$start;
	}
	static function nightHours($effectiveStart,$effectiveEnd,$nightStart,$nightEnd){
		$totalSeconds = 0;
		$endDate = date_format($effectiveEnd,'Y-m-d');
		$endDateU = date_format(date_create($endDate),'U');
		$nightA = $endDateU + $nightStart * 3600;
		$nightB = $endDateU + $nightEnd * 3600;
		$start = date_format($effectiveStart,'U');
		$end = date_format($effectiveEnd,'U');

		if($nightA >= $end || $nightB <= $start ){
			return 0;
		} else if($nightA > $start && $nightB >= $end ){
			return $end - $nightA;
		} else if($nightA >= $start && $nightB <= $end ){
			return $nightB - $nightA;
		} else if($nightA < $start && $nightB < $end){
			return $nightB - $start;
		} else if($nightA < $start && $nightB >= $end){
			return $end - $start;
		}

	}
   

}
