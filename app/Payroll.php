<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Cra;
use App\Shift;
use App\Clock;
use Carbon\Carbon;
use App\Hour;
use App\Datetime;
use App\Employee;
use App\Payroll_log;
use App\Payroll_tip;
use App\Holiday;

class Payroll extends Model
{
    
	public static function twoWeekGrossPay($wk1Hr,$wk2Hr,$year,$holidayPay = 0,$premiumPay = 0){
		$config = DB::table('payroll_config')->where('year',$year)->first();
		$regular = 0; // regular hours worked
		$overtime1 = self::overtime($wk1Hr,$year);
		$overtime2 = self::overtime($wk2Hr,$year);
		$regular += $wk1Hr - $overtime1;
		$regular += $wk2Hr - $overtime2;
		$rp = round($regular * $config->minimumPay/100,2); // pay for regular hours
		$op =  round(($overtime1 + $overtime2) * $config->minimumPay/100 * $config->overtime_pay,2); // pay for overtime hours
		$total = $rp + $op + $holidayPay + $premiumPay;

		$grossIncome = new GrossIncome($wk1Hr,$wk2Hr,$config->minimumPay/100,$overtime1,$overtime2,$rp,$op,$total,$holidayPay);
		return  $grossIncome;
	}
	public static function oneWeekGrossPay($hour,$year,$holidayPay = 0){
		$config = DB::table('payroll_config')->where('year',$year)->first();
		$regular = 0;
		$overtime = self::overtime($hour,$year);
		$regular += $hour - $overtime;
		$rp = $regular * $config->minimumPay/100;
		$op =  $overtime * $config->minimumPay/100 * $config->overtime_pay;
		$total = $regular * $config->minimumPay/100 + $overtime * $config->minimumPay/100 * $config->overtime_pay;

		$gp = array(
			'regular' => $regular,
			'overtime' => $overtime,
			'regularPay' => $rp,
			'overtimePay' => $op,
			'holidayPay' => $holidayPay,
			'grossIncome' => $total + $holidayPay,
		);
		return $gp;
	}

    public static function basicPay($wk1Hr,$wk2Hr,$year){
    	$grossPay = self::twoWeekGrossPay($wk1Hr,$wk2Hr,$year)->total;
    	return Cra::payStub($grossPay,null,null,26,$year,'ON',1);
    }



    public static function overtime($hours,$year){ // calculate overtime hours per week
    	$overtimeHour = DB::table('payroll_config')->select('overtime')->where('year',$year)->first()->overtime;
    	if($hours > $overtimeHour){
    		return $hours - $overtimeHour;
    	} else {
    		return 0;
    	}
    }
    public static function hourlyTip($totalTips,$totalHours){
    	return round($totalTips / $totalHours,2);
    }

    public static function tipShare($type,$year){
    	switch($type){
    		case 1 :
    			return DB::table('payroll_config')->select('server')->where('year',$year)->first()->server;
    		case 2 :
    			return DB::table('payroll_config')->select('cook')->where('year',$year)->first()->cook;
    		case 3 :
    			return DB::table('payroll_config')->select('noodle')->where('year',$year)->first()->noodle;	
    		case 4 :
    			return DB::table('payroll_config')->select('dish')->where('year',$year)->first()->dish;	
    		default: 
    			return false;
    	}
    }

    public static function variablePay($hours,$positionRate,$tipRate,$hourlyTip,$mealRate,$nightRate,$nightHours,$performanceIndex,$bonus){
    	$total = (($positionRate + $tipRate*$hourlyTip) * $hours + $nightRate * $nightHours) * $performanceIndex + $mealRate * $hours + $bonus;
    	$variablePay = new variablePay($hours,$positionRate,$tipRate,$hourlyTip,$mealRate,$nightRate,$nightHours,$performanceIndex,$bonus,round($total,2));
    	return $variablePay;
    }

    public static function cashPay($hours,$rate)
    {
        return $hours*$rate;
    }

    public static function magicNoodlePay($year,$wk1Hr,$wk2Hr,$cashHour = 0,$positionRate,$tipRate,$hourlyTip,$nightHours,$performanceIndex,$bonus,$holidayPay = 0,$premiumPay = 0){

    	$config = DB::table('payroll_config')->where('year',$year)->first();
        $cashRate = $config->cashPay;
    	$mealRate = $config->mealRate;
    	$nightRate = $config->nightRate;
        $vacationPayRate = $config->vacation_pay;

    	$hours = $wk1Hr + $wk2Hr;
    	$twoWeekGrossPay = self::twoWeekGrossPay($wk1Hr,$wk2Hr,$year,$holidayPay,$premiumPay);
        $vacationPay = round($twoWeekGrossPay->total * $vacationPayRate,2);
        $grossPayWithVacationPay = $twoWeekGrossPay->total + $vacationPay ; // vacation pay included for calculating deductibles
    	$basicPay = Cra::payStub($grossPayWithVacationPay,null,null,26,$year,'ON',1);
    	$variablePay = self::variablePay($hours+$cashHour,$positionRate,$tipRate,$hourlyTip,$mealRate,$nightRate,$nightHours,$performanceIndex,$bonus);
    	$cashPay = self::cashPay($cashHour,$cashRate);

        $magicPay = new MagicNoodlePay($twoWeekGrossPay,$basicPay,$variablePay,$cashPay);

    	return $magicPay;
    }

    public static function employeePayrollYear($year,$employee){
    	$dt = Carbon::create($year,1,1,0,0,0);
 		
 		$employee = Employee::findOrFail($employee);
 		$locations = array();

 		foreach($employee->job_location as $location)
 		{


 		$result = array(
 			'totalHours' => 0,
 			'regular' => 0,
 			'overtime'  => 0,
 			'regularPay' => 0,
 			'overtimePay' => 0,
 			'grossIncome' => 0,
 			'federalTax' => 0,
 			'provincialTax' => 0,
 			'EI' => 0,
 			'CPP' => 0,
 			'cheque' => 0,
 			
 			);
    	$weeks = array();
    	
    	for($i = 0; $i < Carbon::WEEKS_PER_YEAR; $i++)
    		{
    			
    			$week = new Week($dt->next(Carbon::MONDAY)->toDateString(),$dt->addDays(6)->toDateString());
    			$hour = Hour::effectiveHour($employee->id,$location->location->id,$week->weekStart,$week->weekEnd);
    			$fourWeekHours = 0;
    			foreach($hour['holidays'] as $holiday){
    				$dt2 = Carbon::createFromFormat('Y-m-d',$holiday->date);
    				$fourWeekEnd = $dt2->startOfWeek()->subDay()->toDateString();
    				$fourWeekStart = $dt2->subWeeks(4)->addDay()->toDateString();
    				$fourWeekHours = Hour::effectiveHour($employee->id,$location->location->id,$fourWeekStart,$fourWeekEnd)['hours'];

    			}
    			$week->holidays = $hour['holidays'];
    			$week->previousFourWeekHours = $fourWeekHours;
    			$week->holidayPay  = round($fourWeekHours * 12 * 1.04 / 20,2);
    			$week->hours = $hour['hours'];
    			$week->grossPay = self::oneWeekGrossPay($week->hours,$year,$week->holidayPay);
    			$week->cheque = Cra::payStub($week->grossPay['grossIncome'],$result['CPP'],$result['EI'],Carbon::WEEKS_PER_YEAR,$year,'ON',1);
    			$weeks[] = $week;

    			$result['totalHours'] += $week->hours;
    			$result['regular'] += $week->grossPay['regular'];
    			$result['overtime'] += $week->grossPay['overtime'];
    			$result['regularPay'] += $week->grossPay['regularPay'];
    			$result['overtimePay'] += $week->grossPay['overtimePay'];
    			$result['grossIncome'] += $week->grossPay['grossIncome'];
    			$result['federalTax'] += $week->cheque->federalTax;
    			$result['provincialTax'] += $week->cheque->provincialTax;
    			$result['EI'] += $week->cheque->EI;
    			$result['CPP'] += $week->cheque->CPP;
    			$result['cheque'] += $week->cheque->net;
  
    		}
    	$result['weeks'] = $weeks;
    	$locations[$location->location->id] = $result;
    	} // end of for each location

    	return $locations;
    }

    public static function payrollCompute($startDate,$location)
    {

        $periodStart =  $startDate;
        $startDate = Carbon::createFromFormat('Y-m-d',$startDate,'America/Toronto')->startOfDay();
        $config = DB::table('payroll_config')->where('year',$startDate->year)->first();
        $basicRate = $config->minimumPay/100;
        $wk1Start = $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();
        if($location == 'all'){
          
             $employeeHours = Hour::where('start',$periodStart)->get();
        } else {

             $employeeHours = Hour::where('start',$periodStart)->where('location_id',$location)->get();
        }

        $count = 0;
        foreach($employeeHours as $e)
        {
            $hourlyTip = Payroll_tip::where('start',$periodStart)->where('location_id',$e->location_id)->first();
            if($hourlyTip){
                $hourlyTip = $hourlyTip->hourlyTip;
            } else {
                $hourlyTip = 0;
            }
            $e->effectiveHour = $e->wk1Effective + $e->wk2Effective; // effective hours
            $e->nightHour = $e->wk1Night + $e->wk2Night + $e->wk1NightCash + $e->wk2NightCash; // night hours
            $e->cashHour = $e->wk1EffectiveCash + $e->wk2EffectiveCash; // cash hours

            //holidays
            $premiumPay = 0;
            $holidayPay = 0;
            $holidays = Holiday::whereBetween('date',[$wk1Start,$wk2End])->get();
            if(count($holidays)){
                $previousPayPeriodStartDate = Carbon::createFromFormat('Y-m-d',$wk1Start)->startOfDay()->subDays(14)->toDateString();
                foreach($holidays as $holiday){
                    $days = 0;
                    $regularPay = 0;

                    $previousPayPeriodDaysWorked = Hour::where('start',$previousPayPeriodStartDate)->
                    where('location_id',$e->location_id)->
                    where('employee_id',$e->employee_id)->
                    first();
                    if($previousPayPeriodDaysWorked){
                        $days = $previousPayPeriodDaysWorked->days;
                    } 
                    $previousPayPeriodRegularIncome = Payroll_log::where('startDate',$previousPayPeriodStartDate)->
                    where('location_id',$e->location_id)->
                    where('employee_id',$e->employee_id)->
                    first();
                    if($previousPayPeriodRegularIncome){
                        $regularPay = $previousPayPeriodRegularIncome->regularPay;
                    } 
                    if($days > 0 && $regularPay > 0){
                        $holidayPay += $regularPay / $days;
                    }     
                }
            } 

            // Performance index
            $performance = Score_log::where('location_id',$e->location_id)->where('employee_id',$e->employee_id)->
                            whereBetween('date',[$periodStart,$wk2End])->sum('value') + 100;
            if($performance > 110)
                $performance = 110; 

            $performance /= 100;
            $bonus = 0;

            $e->magicNoodlePay = self::magicNoodlePay(
                                        Carbon::now()->year,
                                        $e->wk1Effective,
                                        $e->wk2Effective,
                                        $e->cashHour,
                                        $e->employee->job->rate/100,
                                        $e->employee->job->tip,
                                        $hourlyTip,
                                        $e->nightHour,
                                        $performance,
                                        $bonus,$holidayPay,
                                        $premiumPay
                                        );
            // save to payroll log
            if($e->effectiveHour > 0 || $e->cashHour > 0){
                // save to db
                $log = new Payroll_log();
                $log->startDate = $e->start;
                $log->endDate = $e->end;
                $log->location_id = $e->location_id;
                $log->employee_id = $e->employee_id;
                $log->rate = $e->magicNoodlePay->grossPay->basicRate*100;
                $log->week1 = $e->magicNoodlePay->grossPay->week1Hour;
                $log->week2 = $e->magicNoodlePay->grossPay->week2Hour;
                $log->ot1 = $e->wk1Overtime;
                $log->ot2 = $e->wk2Overtime;
                $log->regularPay = $e->magicNoodlePay->grossPay->regularPay*100;
                $log->overtimePay = $e->magicNoodlePay->grossPay->overtimePay*100;
                $log->grossIncome = $e->magicNoodlePay->grossPay->total*100;
                $log->vacationPay = $e->magicNoodlePay->grossPay->total * 0.04 * 100;
                $log->EI = $e->magicNoodlePay->basicPay->EI *100;
                $log->CPP = $e->magicNoodlePay->basicPay->CPP *100;
                $log->federalTax = $e->magicNoodlePay->basicPay->federalTax *100;
                $log->provincialTax = $e->magicNoodlePay->basicPay->provincialTax *100;
                $log->cheque = $e->magicNoodlePay->basicPay->net *100;
                $log->position_rate = $e->magicNoodlePay->variablePay->positionRate *100;
                $log->tip = $e->magicNoodlePay->variablePay->tipRate;
                $log->hourlyTip = $e->magicNoodlePay->variablePay->hourlyTip *100;
                $log->mealRate = $e->magicNoodlePay->variablePay->mealRate *100;
                $log->nightRate = $e->magicNoodlePay->variablePay->nightRate *100;
                $log->nightHours = $e->magicNoodlePay->variablePay->nightHours;
                $log->performance = $e->magicNoodlePay->variablePay->performanceIndex;
                $log->bonus = $e->magicNoodlePay->variablePay->bonus *100;
                $log->variablePay = $e->magicNoodlePay->variablePay->total *100;
                $log->totalPay = $log->cheque*100 + $log->variablePay*100 + $e->magicNoodlePay->cashPay;
                $log->holidayPay = $holidayPay*100;
                $log->premiumPay = $premiumPay*100;
                $log->cashPay = $e->magicNoodlePay->cashPay;
                $log->cashHour = $e->cashHour;
                $log->save();
                $count += 1;
            }
        }
        return $count;
    }
   

     public static function payrollComputeKitchen($startDate,$location){
      
        $periodStart =  $startDate;
        $startDate = Carbon::createFromFormat('Y-m-d',$startDate,'America/Toronto')->startOfDay();
        $config = DB::table('payroll_config')->where('year',$startDate->year)->first();
     
        $wk1Start = $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();
        $employeeHours = Hour::where('start',$periodStart)->where('location_id',$location)->get();
        $count = 0;
        foreach($employeeHours as $e){
         
            $hourlyTip = 0;
           
            $e->effectiveHour = $e->wk1Effective + $e->wk2Effective; // effective hours
            $e->nightHour = $e->wk1Night + $e->wk2Night + $e->wk1NightCash + $e->wk2NightCash; // night hours
            $e->cashHour = $e->wk1EffectiveCash + $e->wk2EffectiveCash; // cash hours

            //holidays
            $premiumPay = 0;
            $holidayPay = 0;
            $holidays = Holiday::whereBetween('date',[$wk1Start,$wk2End])->get();
            if(count($holidays)){
                $previousPayPeriodStartDate = Carbon::createFromFormat('Y-m-d',$wk1Start)->startOfDay()->subDays(14)->toDateString();
                foreach($holidays as $holiday){
                    $days = 0;
                    $regularPay = 0;

                    $previousPayPeriodDaysWorked = Hour::where('start',$previousPayPeriodStartDate)->
                    where('location_id',$e->location_id)->
                    where('employee_id',$e->employee_id)->
                    first();
                    if($previousPayPeriodDaysWorked){
                        $days = $previousPayPeriodDaysWorked->days;
                    } 
                    $previousPayPeriodRegularIncome = Payroll_log::where('startDate',$previousPayPeriodStartDate)->
                    where('location_id',$e->location_id)->
                    where('employee_id',$e->employee_id)->
                    first();
                    if($previousPayPeriodRegularIncome){
                        $regularPay = $previousPayPeriodRegularIncome->regularPay;
                    } 
                    if($days > 0 && $regularPay > 0){
                        $holidayPay += $regularPay / $days;
                    }     
                }
            } 

            // Performance index
            $performance = Score_log::where('location_id',$e->location_id)->where('employee_id',$e->employee_id)->
                            whereBetween('date',[$periodStart,$wk2End])->sum('value') + 100;
            if($performance > 110)
                $performance = 110; 

            $performance /= 100;
            $bonus = 0;

            $e->kitchenPay = self::kitchenPay(
                                        Carbon::now()->year,
                                        $e->employee->job->rate,
                                        $e->wk1Effective,
                                        $e->wk2Effective,
                                        $e->cashHour,
                                        $e->nightHour,
                                        $performance,
                                        $bonus,$holidayPay,
                                        $premiumPay
                                        );
            // save to payroll log
            if($e->effectiveHour > 0 || $e->cashHour > 0){
                // save to db
                $log = new Payroll_log();
                $log->startDate = $e->start;
                $log->endDate = $e->end;
                $log->location_id = $e->location_id;
                $log->employee_id = $e->employee_id;

                $log->rate = $e->employee->job->rate;

                $log->week1 = $e->wk1Effective;
                $log->week2 = $e->wk2Effective;
                $log->ot1 = $e->wk1Overtime;
                $log->ot2 = $e->wk2Overtime;
                $log->regularPay = $e->kitchenPay->grossPay->regularPay*100;
                $log->overtimePay = $e->kitchenPay->grossPay->overtimePay*100;
                $log->grossIncome = $e->kitchenPay->grossPay->total*100;

                $log->vacationPay = $e->kitchenPay->grossPay->total * 0.04 * 100;
                $log->EI = $e->kitchenPay->basicPay->EI *100;
                $log->CPP = $e->kitchenPay->basicPay->CPP *100;
                $log->federalTax = $e->kitchenPay->basicPay->federalTax *100;
                $log->provincialTax = $e->kitchenPay->basicPay->provincialTax *100;
                $log->cheque = $e->kitchenPay->basicPay->net *100;
                $log->position_rate = 0;
                $log->tip = 0;
                $log->hourlyTip = 0;
                $log->mealRate = 0;
                $log->nightRate = $e->kitchenPay->variablePay->nightRate *100;
                $log->nightHours = $e->kitchenPay->variablePay->nightHours;
                $log->performance = $e->kitchenPay->variablePay->performanceIndex;
                $log->bonus = $e->kitchenPay->variablePay->bonus *100;
                $log->variablePay = $e->kitchenPay->variablePay->total *100;
                $log->totalPay = $log->cheque*100 + $log->variablePay*100 + $e->kitchenPay->cashPay;
                $log->holidayPay = $holidayPay*100;
                $log->premiumPay = $premiumPay*100;
                $log->cashPay = $e->kitchenPay->cashPay;
                $log->cashHour = $e->cashHour;
                $log->save();
                $count += 1;
            }
        }
        return $count;
    }


    private static function  kitchenPay($year,$rate,$wk1Hr,$wk2Hr,$cashHour,$nightHours,$performanceIndex,$bonus,$holidayPay,$premiumPay){

        $config = DB::table('payroll_config')->where('year',$year)->first();
        $mealRate = 0;
        $nightRate = $config->nightRate;
        $vacationPayRate = $config->vacation_pay;

        $hours = $wk1Hr + $wk2Hr;
        $twoWeekGrossPay = self::twoWeekGrossPayKitchen($year,$rate/100,$wk1Hr,$wk2Hr,$holidayPay,$premiumPay);
        $vacationPay = round($twoWeekGrossPay->total * $vacationPayRate,2);
        $grossPayWithVacationPay = $twoWeekGrossPay->total + $vacationPay ; // vacation pay included for calculating deductibles
        $basicPay = Cra::payStub($grossPayWithVacationPay,null,null,26,$year,'ON',1);
        $variablePay = self::variablePay($hours+$cashHour,0,0,0,0,$nightRate,$nightHours,$performanceIndex,$bonus);
        $cashRate = $config->cashPay;
        $cashPay = self::cashPay($cashHour,$cashRate);

        $kitchenPay = new MagicNoodlePay($twoWeekGrossPay,$basicPay,$variablePay,$cashPay);

        return $kitchenPay;
    }
    public static function twoWeekGrossPayKitchen($year,$rate,$wk1Hr,$wk2Hr,$holidayPay,$premiumPay){
        $config = DB::table('payroll_config')->where('year',$year)->first();
        $regular = 0; // regular hours worked
        $overtime1 = self::overtime($wk1Hr,$year);
        $overtime2 = self::overtime($wk2Hr,$year);
        $regular += $wk1Hr - $overtime1;
        $regular += $wk2Hr - $overtime2;
        $rp = round($regular * $rate,2); // pay for regular hours
        $op =  round(($overtime1 + $overtime2) * $rate * $config->overtime_pay,2); // pay for overtime hours
        $total = $rp + $op + $holidayPay + $premiumPay;
        // $total = $rp + $op;

        return new GrossIncome($wk1Hr,$wk2Hr,$rate,$overtime1,$overtime2,$rp,$op,$total,$holidayPay);
        
    }

}
Class Week
{
	public $weekStart;
	public $weekEnd;
	public $grossPay;
	public $cheque;
	public $holidays;
	function __construct($start,$end){
		$this->weekStart = $start;
		$this->weekEnd = $end;
	}
}


Class GrossIncome
{
	public $week1Hour;
	public $week2Hour;
	public $basicRate;
	public $overtime1;
	public $overtime2;
	public $regularPay;
	public $overtimePay;
    public $holidayPay;
	public $total;
	function __construct($wk1Hr,$wk2Hr,$rate,$ot1,$ot2,$rp,$op,$total,$holidayPay = 0){
		$this->week1Hour = $wk1Hr;
		$this->week2Hour = $wk2Hr;
		$this->basicRate = $rate;
		$this->overtime1 = $ot1;
		$this->overtime2 = $ot2;
		$this->regularPay = $rp;
		$this->overtimePay = $op;
		$this->total = $total;
		$this->holidayPay = $holidayPay;
	}
}

Class MagicNoodlePay
{
	public $totalHours;
	public $netPay;
	public $grossPay;
	public $basicPay;
	public $variablePay;
    public $cashPay;
	function __construct($grossPay,$basicPay,$variablePay,$cashPay){
		$this->grossPay = $grossPay;
		$this->basicPay = $basicPay;
		$this->variablePay = $variablePay;
		$this->totalHours = $variablePay->totalHours;
		$this->netPay = $basicPay->net + $variablePay->total + $cashPay;
        $this->cashPay = $cashPay;
	}
}

Class VariablePay
{
	public $totalHours;
	public $positionRate;
	public $tipRate;
	public $hourlyTip;
	public $mealRate;
	public $nightRate;
	public $nightHours;
	public $performanceIndex;
	public $bonus;
	public $total;
	function __construct($hours,$positionRate,$tipRate,$hourlyTip,$mealRate,$nightRate,$nightHours,$performanceIndex,$bonus,$total){
		$this->totalHours = $hours;
		$this->positionRate = $positionRate;
		$this->tipRate = $tipRate;
		$this->hourlyTip = $hourlyTip;
		$this->mealRate = $mealRate;
		$this->nightRate = $nightRate;
		$this->nightHours = $nightHours;
		$this->performanceIndex = $performanceIndex;
		$this->bonus = $bonus;	
		$this->total = $total;
	}

}
