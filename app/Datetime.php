<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class Datetime extends Model
{
    
    public static function periods($year)
    {
    	if(!empty($year)){
			$periods = DB::table('payroll_period')->where('year',$year)->get();
    	} else {
    		$periods = DB::table('payroll_period')->get();
    	}
    	
    	$periodOptions = array();
    	foreach($periods as $p){
    		$periodOptions[$p->start] = $p->start.' - '.$p->end;
    	}
    	return $periodOptions;
    }

    public static function pastYears($past){
        $year = Carbon::now();
        $years = array();
        for($i = 0; $i < $past; $i++)
        {
            $years[$year->year] = $year->year;
            $year->subYear();
        }
        return $years;
    }

    public static function payFrequency()
    {
        return [
            'week' => 'Weekly',
            'bi' => 'Biweekly',
            'm' => 'Monthly',
        ];
    }

    public static function shiftParser($shiftString)
    {
        $trimedStr =  strtolower(str_replace(' ',null,$shiftString));
        $separator = '-';
        if(substr_count($trimedStr,$separator) == 1){

            $data = explode($separator,$trimedStr);
            if(count($data) == 2){

                if(strlen($data[0]) <= 7){
                    $data[0] = self::parseTime($data[0]);
                } else {
                    return 'wrong start date format';
                }
                if(strlen($data[1]) <= 7){
                    $data[1] = self::parseTime($data[1]);
                } else {
                    return 'wrong end date format';
                }

                return $data;
            } else
            {
                return 'invalid format 2';
            } 
        } else {
            return 'invalid format';
        }
    }
    private static function parseTime($time)
    {
        if(substr_count($time,'p') == 1 || substr_count($time,'pm')){
            $strpos = strpos($time,'p');
            $time = substr($time,0,$strpos);
            $data = explode(':',$time);
            //dd($data[1]);
            $h = $data[0];
            $m = isset($data[1]) ? intval($data[1]) : 0;
            if( $h >= 0){   // treat the hour part
                if($h <= 12 ) {
                $h = intval($h) + 12;
                $data['hour'] = $h;
               
                }
            } else {
                $data['status'] = 'Hour below 0';
            }
            
            if( $m >= 0 && $m < 60 ){
                 $data['minute'] = $m;
            } else {
                $data['minute'] = 0;
                $data['status'] = 'Minute out of range';
            }
            $data['ampm'] = 'p';
            //$m = $data[1];


        }
        if(substr_count($time,'a') == 1 || substr_count($time,'am')){
           $strpos = strpos($time,'a');
            $time = substr($time,0,$strpos);
            $data = explode(':',$time);
            //dd($data[1]);
            $h = $data[0];
            $m = isset($data[1]) ? intval($data[1]) : 0;
            if( $h >= 0){   // treat the hour part
                if($h <= 12 ) {
                $h = intval($h);
                $data['hour'] = $h;
               
                }
            } else {
                $data['status'] = 'Hour below 0';
            }
            
            if( $m >= 0 && $m < 60 ){
                 $data['minute'] = $m;
            } else {
                $data['minute'] = 0;
                $data['status'] = 'Minute out of range';
            }
            $data['ampm'] = 'a';


        }
        return $data;
    }
}
