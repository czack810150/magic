<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Cra;

class Payroll extends Model
{
    
	public static function twoWeekGrossPay($wk1Hr,$wk2Hr,$year){
		$config = DB::table('payroll_config')->where('year',$year)->first();
		$regular = 0;
		$overtime1 = self::overtime($wk1Hr,$year);
		$overtime2 = self::overtime($wk2Hr,$year);
		$regular += $wk1Hr - $overtime1;
		$regular += $wk2Hr - $overtime2;
		return $regular * $config->minimumPay/100 + ($overtime1 + $overtime2) * $config->minimumPay/100 * $config->overtime_pay;
	}

    public static function basicPay($wk1Hr,$wk2Hr,$year){
    	$grossPay = self::twoWeekGrossPay($wk1Hr,$wk2Hr,$year);
    	return Cra::payStubs([$grossPay],26,$year,'ON',1);
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

}
