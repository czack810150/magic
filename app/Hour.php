<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Clock;
use App\Shift;
use App\Employee;
use App\Holiday;
use Carbon\Carbon;

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
		$holidays = Holiday::whereDate('date','>=',$start)->whereDate('date','<',$end)->get();

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
				'holidays' => $holidays,
			);
				return $result;
		
		} else {
			$result = array(
				'seconds' => 0,
				'hours' => 0,
				//'late' => $totalLateMinutes,
				'nightSeconds' => 0,
				'nightHours' => 0,
				'holidays' => $holidays,
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

	static function hoursEngine($startDate)
	{
		
    	$startDate = Carbon::createFromFormat('Y-m-d',$startDate,'America/Toronto')->startOfDay();
    	$config = DB::table('payroll_config')->where('year',$startDate->year)->first();
        $wk1Start =  $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();
        $employees = Employee::whereBetween('termination',[$wk1Start,$wk2End])->orWhere('termination',null)->get();
        $result = array(
        	//'employees' => array(),
        );
        
        foreach($employees as $e)
        {
        	// $hours['employees']['employee_id'] = $e->id;
        	// $hours['employees']['cName'] = $e->cName;
        	// $hours['employees']['scheduled'] = array(); 
        	$hour = new HourObj($e->id,$e->cName,$e->employeeNumber,$wk1Start,$wk2End);

        	// get all locations that matter for this employee in period
        	$locations = array_unique(Shift::where('employee_id',$e->id)->whereBetween('start',[$wk1Start,$wk2End])->pluck('location_id')->toArray());


        	foreach($locations as $location)
        	{
        		$breakDown = New HourBreakDown;
        		//$hours['employees']['scheduled'][] = self::scheduledHour($e->id,$location,$wk1Start,$wk1End);
        		$breakDown->location_id = $location;
        		$breakDown->wk1Scheduled = self::scheduledHour($e->id,$location,$wk1Start,$wk1End);
        		$breakDown->wk2Scheduled = self::scheduledHour($e->id,$location,$wk2Start,$wk2End);
        		$breakDown->wk1Clocked = self::clockedHour($e->id,$location,$wk1Start,$wk1End);
        		$breakDown->wk2Clocked = self::clockedHour($e->id,$location,$wk2Start,$wk2End);
        		$wk1Effective = self::effectiveHour($e->id,$location,$wk1Start,$wk1End);
        		$wk2Effective = self::effectiveHour($e->id,$location,$wk2Start,$wk2End);
        		$breakDown->wk1Effective = $wk1Effective['hours'];
        		$breakDown->wk2Effective = $wk2Effective['hours'];
        		$breakDown->wk1Night = $wk1Effective['nightHours'];
        		$breakDown->wk2Night = $wk2Effective['nightHours'];
        		$breakDown->wk1Overtime = self::overtime($breakDown->wk1Effective,$config->overtime);
        		$breakDown->wk2Overtime = self::overtime($breakDown->wk2Effective,$config->overtime);
        		$hour->works[] = $breakDown;

        		//save to db
        		if($breakDown->wk1Scheduled > 0 ||$breakDown->wk2Scheduled > 0)
        		{
        			$HOUR = new Hour;
        			$HOUR->start = $wk1Start;
        			$HOUR->end = $wk1End;
        			$HOUR->employee_id = $e->id;
        			$HOUR->location_id = $location;
        			$HOUR->wk1Scheduled = $breakDown->wk1Scheduled;
        			$HOUR->wk2Scheduled = $breakDown->wk2Scheduled;
        			$HOUR->wk1Clocked = $breakDown->wk1Clocked;
        			$HOUR->wk2Clocked = $breakDown->wk2Clocked;
        			$HOUR->wk1Effective = $breakDown->wk1Effective;
        			$HOUR->wk2Effective = $breakDown->wk2Effective;
        			$HOUR->wk1Night = $breakDown->wk1Night;
        			$HOUR->wk2Night = $breakDown->wk2Night;
        			$HOUR->wk1Overtime = $breakDown->wk1Overtime;
        			$HOUR->wk2Overtime = $breakDown->wk2Overtime;
        			$HOUR->save();
        		}
        		

        		
        	}
        	$result[] = $hour;
        	
        }

        return $result;
	}
 	public static function overtime($hours,$overtimeHour){ // calculate overtime hours per week
    	
    	if($hours > $overtimeHour){
    		return $hours - $overtimeHour;
    	} else {
    		return 0;
    	}
    }  

}

class HourObj{
	public $employee_id,$name,$card,$start,$end;
	public $works = array();
	public function __construct($employee,$name,$card,$start,$end){
		$this->employee_id = $employee;
		$this->card = $card;
		$this->name = $name;
		$this->start = $start;
		$this->end = $end;
	}
}

class HourBreakDown {
	public $location_id,$wk1Scheduled,$wk1Clocked,$wk1Effective,$wk1Night,$wk1Overtime;
	public $wk2Scheduled,$wk2Clocked,$wk2Effective,$wk2Night,$wk2Overtime;
}
