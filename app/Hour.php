<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Clock;
use App\Shift;
use App\Employee;
use App\Holiday;
use App\Location;
use Carbon\Carbon;

class Hour extends Model
{
	public function location()
	{
		return $this->belongsTo('App\Location');
	}
	public function employee()
	{
		return $this->belongsTo('App\Employee');
	}
    
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
        ->where('special',0)
        ->where('start','>=',$start)->whereDate('start','<=',$end)
        ->first()->total;
    }
    public static function scheduledHourCash($employee,$location,$start,$end){
    	return DB::table('shifts')->select(DB::raw('sum(UNIX_TIMESTAMP(end)-UNIX_TIMESTAMP(start))/3600 as total'))
        ->where('location_id',$location)
        ->where('employee_id',$employee)
        ->where('special',1)
        ->where('start','>=',$start)->whereDate('start','<=',$end)
        ->first()->total;
    }
    public static function clockedHour($employee,$location,$start,$end){
    	return DB::table('clocks')->select(DB::raw('sum(UNIX_TIMESTAMP(clockOut)-UNIX_TIMESTAMP(clockIn))/3600 as total'))
        ->where('location_id',$location)
        ->where('employee_id',$employee)
        ->where('clockIn','>=',$start)->whereDate('clockIn','<=',$end)
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

		$shifts = Shift::where('employee_id',$employee)->where('location_id',$location)->where('special',0)->where('start','>=',$start)->whereDate('start','<=',$end)->orderBy('start')->get();

	    
    	if(count($shifts)){
		foreach($shifts as $s){
					$planedStart = date_create($s->start);
					$planedEnd = date_create($s->end);

					$shiftDate = date_format($planedStart,'Y-m-d');
					$nextDay = Carbon::createFromFormat('Y-m-d',$shiftDate)->addDay()->toDateString();
					
					$clockedHours = self::clockedShifts($employee,$location,$shiftDate,$nextDay);	

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
     public static function effectiveHourCash($employee,$location,$start,$end)
    {
    	//config
    	$nightStart = 1;
    	$nightEnd = 6;
    	// statistics 
		$totalSeconds = 0;
		$totalLateMinutes = 0;
		$totalNightSeconds = 0;
		$holidays = Holiday::whereDate('date','>=',$start)->whereDate('date','<',$end)->get();

		$shifts = Shift::where('employee_id',$employee)->where('location_id',$location)->where('special',1)->where('start','>=',$start)->whereDate('start','<=',$end)->orderBy('start')->get();

	    
    	if(count($shifts)){
		foreach($shifts as $s){
					$planedStart = date_create($s->start);
					$planedEnd = date_create($s->end);

					$shiftDate = date_format($planedStart,'Y-m-d');
					$nextDay = Carbon::createFromFormat('Y-m-d',$shiftDate)->addDay()->toDateString();
					
					$clockedHours = self::clockedShifts($employee,$location,$shiftDate,$nextDay);	

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


	public static function computeHours($startDate,$location)
	{
		$count = 0;
		$startDate = Carbon::createFromFormat('Y-m-d',$startDate,'America/Toronto')->startOfDay();
		$config = DB::table('payroll_config')->where('year',$startDate->year)->first();
		$wk1Start =  $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();
        $wk2EndPlusOne = $startDate->addDay()->toDateString();

        $locationShifts = Shift::where('location_id',$location)->whereBetween('start',[$wk1Start,$wk2EndPlusOne])->get();
      
        $employees = $locationShifts->map(function($item,$key){
        		return $item->employee_id;
        });
        $employees = $employees->unique()->values()->all();
        
        foreach($employees as $eid)
        {

        	$HOUR = new Hour;
        			$HOUR->start = $wk1Start;
        			$HOUR->end = $wk2End;
        			$HOUR->employee_id = $eid;
        			$HOUR->location_id = $location;
        			//new, get the days worked for the peirod( scheduled days )
        			$HOUR->days = count(Shift::select(DB::raw('DATE(start)'))->where('employee_id',$eid)->where('location_id',$location)->whereBetween('start',[$wk1Start,$wk2End.' 23:59:59'])->distinct()->get());
        			$HOUR->wk1Scheduled = self::scheduledHour($eid,$location,$wk1Start,$wk1End);
        			$HOUR->wk2Scheduled = self::scheduledHour($eid,$location,$wk2Start,$wk2End);
        			$HOUR->wk1ScheduledCash = self::scheduledHourCash($eid,$location,$wk1Start,$wk1End);
        			$HOUR->wk2ScheduledCash = self::scheduledHourCash($eid,$location,$wk2Start,$wk2End);
        			$HOUR->wk1Clocked = self::clockedHour($eid,$location,$wk1Start,$wk1End);
        			$HOUR->wk2Clocked = self::clockedHour($eid,$location,$wk2Start,$wk2End);

        			$wk1Effective = self::effectiveHour($eid,$location,$wk1Start,$wk1End);
        			$wk2Effective = self::effectiveHour($eid,$location,$wk2Start,$wk2End);
        			$wk1EffectiveCash = self::effectiveHourCash($eid,$location,$wk1Start,$wk1End);
        			$wk2EffectiveCash = self::effectiveHourCash($eid,$location,$wk2Start,$wk2End);

        			$HOUR->wk1Effective = $wk1Effective['hours'];
        			$HOUR->wk2Effective = $wk2Effective['hours'];
        			$HOUR->wk1EffectiveCash = $wk1EffectiveCash['hours'];
        			$HOUR->wk2EffectiveCash = $wk2EffectiveCash['hours'];
        			$HOUR->wk1Night = $wk1Effective['nightHours'];
        			$HOUR->wk2Night = $wk2Effective['nightHours'];
        			$HOUR->Wk1NightCash = $wk1EffectiveCash['nightHours'];
        			$HOUR->Wk2NightCash = $wk2EffectiveCash['nightHours'];
        			$HOUR->wk1Overtime = self::overtime($wk1Effective['hours'],$config->overtime);
        			$HOUR->wk2Overtime = self::overtime($wk2Effective['hours'],$config->overtime);
        			$HOUR->save();
        			$count += 1;
        }
        return $count;

	}

	static function hoursEngine($startDate)
	{
    	$startDate = Carbon::createFromFormat('Y-m-d',$startDate,'America/Toronto')->startOfDay();
    	$config = DB::table('payroll_config')->where('year',$startDate->year)->first();
        $wk1Start =  $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();
        $wk2EndPlusOne = $startDate->addDay()->toDateString();
        $employees = Employee::whereBetween('termination',[$wk1Start,$wk2End])->orWhere('termination',null)->orderBy('location_id')->orderBy('job_id')->get();
        $result = array(
        );
        $count = 0;
        foreach($employees as $e)
        {
        	$hour = new HourObj($e->id,$e->cName,$e->employeeNumber,$wk1Start,$wk2End);
        	// get all locations that matter for this employee in period
        	
            $locations = array_unique(Shift::where('employee_id',$e->id)->whereBetween('start',[$wk1Start,$wk2EndPlusOne])->pluck('location_id')->toArray());
        	
        	
        	foreach($locations as $location)
        	{
        		$breakDown = New HourBreakDown;
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
        		if(!is_null($breakDown->wk1Scheduled) || !is_null($breakDown->wk2Scheduled) )
        		{
        			$HOUR = new Hour;
        			$HOUR->start = $wk1Start;
        			$HOUR->end = $wk2End;
        			$HOUR->employee_id = $e->id;
        			$HOUR->location_id = $location;
        			//new, get the days worked for the peirod( scheduled days )
        			$HOUR->days = count(Shift::select(DB::raw('DATE(start)'))->where('employee_id',$e->id)->where('location_id',$location)->whereBetween('start',[$wk1Start,$wk2End.' 23:59:59'])->distinct()->get());
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
        			$count += 1;
        		}
        	}
        	$result[] = $hour;
        }
        return $count;
	}
 	public static function overtime($hours,$overtimeHour){ // calculate overtime hours per week
    	
    	if($hours > $overtimeHour){
    		return $hours - $overtimeHour;
    	} else {
    		return 0;
    	}
    }

    public static function breakdown($employee,$location,$startDate)
    {
    	//config
    	$config = DB::table('payroll_config')->where('year',2017)->first(); // for year to year change
    	//$config = DB::table('payroll_config')->where('year',Carbon::now()->year)->first();
    	$startDate = Carbon::createFromFormat('Y-m-d',$startDate,'America/Toronto')->startOfDay();
        $start =  $startDate->toDateString();
        $end = $startDate->addDays(14)->toDateString();
        $shifts = Shift::where('employee_id',$employee)->where('location_id',$location)->whereBetween('start',[$start,$end])->orderBy('start')->get();
        $result = array();
        foreach($shifts as $s)
        {

			$data['clockedDayTotal'] = 0;
			$shiftStart = Carbon::createFromFormat('Y-m-d H:i:s',$s->start);
			$shiftEnd = Carbon::createFromFormat('Y-m-d H:i:s',$s->end);
			$data['shiftDate'] = $shiftStart->toDateString();
			$data['scheduleIn'] = $shiftStart->format('H:i');
			if( $shiftStart->toDateString() == $shiftEnd->toDateString() ){
				$data['scheduleOut'] = $shiftEnd->format('H:i');
			} else {
				$data['scheduleOut'] = $shiftEnd->format('次日 H:i');
			}
			$data['scheduledHour'] = round($shiftStart->diffInSeconds($shiftEnd)/3600,2);

			$data['clocks'] = self::clockHours($employee,$location,$s->start,$s->end);
			$data['totalClock'] = 0;
			foreach($data['clocks'] as $c){
				$clockIn =  Carbon::createFromFormat('Y-m-d H:i:s',$c->clockIn);
				$clockOut =  Carbon::createFromFormat('Y-m-d H:i:s',$c->clockOut);
				$c->clockTime = round($clockIn->diffInSeconds($clockOut)/3600,2);
				$data['totalClock'] += $c->clockTime;
			}
			$data['effectiveHours'] = self::effectiveShift($shiftStart,$shiftEnd,$data['clocks'],$config);

			//$clocks = Shift::where('employee_id',$employee)->where('location_id',$location)->whereBetween('clockIn',[$start,$shift->])->get();

			$result[] = $data;
		}
		return $result;	  
    }
    static function clockHours($employee,$location,$theDate,$endDate)
    {
    	$dt = Carbon::createFromFormat('Y-m-d H:i:s',$theDate);
    	$end = Carbon::createFromFormat('Y-m-d H:i:s',$endDate);
    	$previousDate = $dt->subHours(2)->toDateString();
    	$clocks = Clock::where('employee_id',$employee)->where('location_id',$location)->whereBetween('clockIn',[$previousDate,$end->endOfDay()->toDateTimeString()])->get();
    	return $clocks;
    }
    static function effectiveShift($planedStart,$planedEnd,$clocks,$config)
    {
    	$totalLateMinutes = 0;
    	$totalSeconds = 0;
    	foreach($clocks as $c)
    	{
    		$clockIn =  Carbon::createFromFormat('Y-m-d H:i:s',$c->clockIn);
			$clockOut =  Carbon::createFromFormat('Y-m-d H:i:s',$c->clockOut);
			// comming to work
					// check if current clock in is later than the current shift off time
					if(($clockIn > $planedEnd && $clockIn > $planedStart) || ($clockOut < $planedStart && $clockOut < $planedEnd) ){
						continue;
					} else {
					if($clockIn > $planedStart) { // late for work
						$aggregatedStart = $clockIn;
						$lateBegin = $clockIn->diffInMinutes($planedStart);
						if($lateBegin > $config->lateIn){ // late for work over defined late standard
							$totalLateMinutes += $lateBegin;
						}
		// 					leaving
							if($clockOut <= $planedEnd) { // left early
								$aggregatedEnd = $clockOut;
							} else {
								$aggregatedEnd = $planedEnd;
								// $aggregatedEnd = $this->smartOut($clockOut,$planedEnd,$aggregatedStart); // for now, left late, we use planed leave time
								}
					} else { // early for work
						$aggregatedStart = $planedStart;
						if($clockOut <= $planedEnd) { // left early
							$aggregatedEnd = $clockOut;
						}  else {
								$aggregatedEnd = $planedEnd;
								 // $aggregatedEnd = $this->smartOut($clockOut,$planedEnd,$aggregatedStart); // for now, left late, we use planed leave time
								}
						}
			$totalSeconds += $aggregatedStart->diffInSeconds($aggregatedEnd);
    		}
    	}
   				 $result = array(
					'seconds' => $totalSeconds,
					'hours' => round($totalSeconds/3600,2),
					'late' => $totalLateMinutes,
					);
				return $result;

    }

    static function openings($employee,$location,$start,$end)
    {
    	$location = Location::find($location);
 
    	$data['openings'] = 0;
    	$data['endClose'] = 0;
    	$data['lunch'] = 0;
    	$data['dinner'] = 0;
    	$data['night'] = 0;
    	$clockedShifts = Clock::where('location_id',$location->id)->where('employee_id',$employee)->whereDate('clockIn','>=',$start)->whereDate('clockOut','<=',$end)->get();
    	foreach($clockedShifts as $c)
    	{
    		$cIn = Carbon::createFromFormat('Y-m-d H:i:s',$c->clockIn);
    		$cOut = Carbon::createFromFormat('Y-m-d H:i:s',$c->clockOut);
 
    		if($cIn->toTimeString() <= $location->openMorning && $cOut->toTimeString() >= $location->endMorning ){
    			$data['openings'] += 1;
    		}
    		
    		if($cIn->toTimeString() <= $location->lunchStart && $cOut->toTimeString() >= $location->lunchEnd ){
    			$data['lunch'] += 1;
    		}
    		if($cIn->toTimeString() <= $location->dinnerStart && $cOut->toTimeString() >= $location->dinnerEnd ){
    			$data['dinner'] += 1;
    		}
    		if(!is_null($location->nightStart)){
    			if($cIn->toTimeString() <= $location->nightStart && $cOut->toTimeString() >= $location->nightEnd ){
    			$data['night'] += 1;
    		}
    		}
    		// night close
    		if($cIn->toDateString() == $cOut->toDateString()){  // night close at the same calendar date
    			if($cIn->toTimeString() <= $location->endClose && $cOut->toTimeString() >= $location->endClose ){
    				$data['endClose'] += 1;
    			}
    		} else {  // night close at differnt calendar dates
    			if( $cOut->toTimeString() >= $location->endClose ){
    				$data['endClose'] += 1;
    			}
    		}
    		
    	}

    	return $data;
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
	public $location_id,$wk1Scheduled,$wk1Clocked,$wk1Effective,$wk1Night,$wk1Overtime = 0;
	public $wk2Scheduled,$wk2Clocked,$wk2Effective,$wk2Night,$wk2Overtime = 0;
}
