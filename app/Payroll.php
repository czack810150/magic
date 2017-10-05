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

class Payroll extends Model
{
    
	public static function twoWeekGrossPay($wk1Hr,$wk2Hr,$year){
		$config = DB::table('payroll_config')->where('year',$year)->first();
		$regular = 0;
		$overtime1 = self::overtime($wk1Hr,$year);
		$overtime2 = self::overtime($wk2Hr,$year);
		$regular += $wk1Hr - $overtime1;
		$regular += $wk2Hr - $overtime2;
		$rp = $regular * $config->minimumPay/100;
		$op =  ($overtime1 + $overtime2) * $config->minimumPay/100 * $config->overtime_pay;
		$total = $regular * $config->minimumPay/100 + ($overtime1 + $overtime2) * $config->minimumPay/100 * $config->overtime_pay;

		$grossIncome = new GrossIncome($wk1Hr,$wk2Hr,$config->minimumPay/100,$overtime1,$overtime2,$rp,$op,$total);
		return  $grossIncome;
	}
	public static function oneWeekGrossPay($hour,$year){
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
			'grossIncome' => $total,
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
    	$total = (($positionRate + $tipRate*$hourlyTip + $mealRate) * $hours + $nightRate * $nightHours) * $performanceIndex + $bonus;

    	$variablePay = new variablePay($hours,$positionRate,$tipRate,$hourlyTip,$mealRate,$nightRate,$nightHours,$performanceIndex,$bonus,round($total,2));
    	return $variablePay;
    }

    public static function magicNoodlePay($year,$wk1Hr,$wk2Hr,$positionRate,$tipRate,$hourlyTip,$nightHours,$performanceIndex,$bonus){

    	$config = DB::table('payroll_config')->where('year',$year)->first();
    	$mealRate = $config->mealRate;
    	$nightRate = $config->nightRate;

    	$hours = $wk1Hr + $wk2Hr;
    	$twoWeekGrossPay = self::twoWeekGrossPay($wk1Hr,$wk2Hr,$year);
    	$basicPay = Cra::payStub($twoWeekGrossPay->total,null,null,26,$year,'ON',1);
    	$variablePay = self::variablePay($hours,$positionRate,$tipRate,$hourlyTip,$mealRate,$nightRate,$nightHours,$performanceIndex,$bonus);
    	$magicPay = new MagicNoodlePay($twoWeekGrossPay,$basicPay,$variablePay);
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
    			$week->hours = $hour['hours'];
    			$week->grossPay = self::oneWeekGrossPay($week->hours,$year);
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
}
Class Week
{
	public $weekStart;
	public $weekEnd;
	public $grossPay;
	public $cheque;
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
	public $total;
	function __construct($wk1Hr,$wk2Hr,$rate,$ot1,$ot2,$rp,$op,$total){
		$this->week1Hour = $wk1Hr;
		$this->week2Hour = $wk2Hr;
		$this->basicRate = $rate;
		$this->overtime1 = $ot1;
		$this->overtime2 = $ot2;
		$this->regularPay = $rp;
		$this->overtimePay = $op;
		$this->total = $total;
	}
}

Class MagicNoodlePay
{
	public $totalHours;
	public $netPay;
	public $grossPay;
	public $basicPay;
	public $variablePay;
	
	
	function __construct($grossPay,$basicPay,$variablePay){
		//$this->twoWeekGrossPay = $twoWeekGrossPay;
		$this->grossPay = $grossPay;
		$this->basicPay = $basicPay;
		$this->variablePay = $variablePay;
		$this->totalHours = $variablePay->totalHours;
		$this->netPay = $basicPay->net + $variablePay->total;
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
