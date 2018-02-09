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
                    $data['from'] = self::parseTime($data[0]);
                } else {
                    return 'wrong start date format';
                }
                if(strlen($data[1]) <= 7){
                    $data['to'] = self::parseTime($data[1]);
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
         if(substr_count($time,'a') == 1 || substr_count($time,'am') == 1 ){

            $data['ampm'] = 'a';
            $strpos = strpos($time,'a');
            $time = substr($time,0,$strpos);

            if(substr_count($time,':') == 1){
                $data = explode(':',$time);
                $h = $data[0];
                $m = isset($data[1]) ? intval($data[1]) : 0;
            if( $h >= 0 && $h <= 11 ){   // treat the hour part
               
                $h = intval($h);
                $data['hour'] = $h;
                $data['ampm'] = 'a';
            

            } else if( $h >= 12 && $h < 24 ){
                $h = intval($h);
                $data['hour'] = $h;
                $data['ampm'] = 'p';

            } else if($h == 24){
                $data['hour'] = 0;
                $data['ampm'] = 'a';
            }  else  {
                $data['error'] = 'Hour out of range';
            }
            
            if( $m >= 0 && $m < 60 ){
                 $data['minute'] = $m;
            } else {
                $data['minute'] = 0;
                $data['status'] = 'Minute out of range';
            }

            } else if(substr_count($time,':') == 0)
            {
                $h = intval($time);
                $data['minute'] = 0;

                if($h >= 0 && $h < 12){
                    $data['hour'] = $h;
                } else if($h >=12 && $h <24)
                {
                    $data['ampm'] = 'p';
                    $data['hour'] = $h;

                } else if($h == 24) {
                    $data['hour'] = 0;
                    $data['ampm'] = 'a';
                } else {
                    $data['error'] = 'hour is out of range (0 - 24)';
                }

            } else {
                return "invalid format about ':'";
            }


            
            
        } // end of am part
         else if(substr_count($time,'p') == 1 || substr_count($time,'pm') == 1){
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
                }  else {
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


        } // end of pm part
            else {  // string does not contain affix a or p
                if(substr_count($time,':') == 1){
                $data = explode(':',$time);
                $h = $data[0];
                $m = isset($data[1]) ? intval($data[1]) : 0;
            if( $h >= 0 && $h <= 11 ){   // treat the hour part
               
                $h = intval($h);
                $data['ampm'] = 'a';
                $data['hour'] = $h;

            } else if( $h >= 12 && $h < 24 ){
                $h = intval($h);
                $data['hour'] = $h;
                $data['ampm'] = 'p';

            } else if($h == 24){
                $data['ampm'] = 'a';
                $data['hour'] = 0;
                
            }  else  {
                $data['error'] = 'Hour out of range';
            }
            
            if( $m >= 0 && $m < 60 ){
                 $data['minute'] = $m;
            } else {
                $data['minute'] = 0;
                $data['status'] = 'Minute out of range';
            }

            } else if(substr_count($time,':') == 0)
            {
                $h = intval($time);
                $data['minute'] = 0;

                if($h >= 0 && $h < 12){
                     $data['ampm'] = 'a';
                    $data['hour'] = $h;
                } else if($h >=12 && $h <24)
                {
                    $data['ampm'] = 'p';
                    $data['hour'] = $h;

                } else if($h == 24) {
                    $data['ampm'] = 'a';
                    $data['hour'] = 0;
                    
                } else {
                    $data['error'] = 'hour is out of range (0 - 24)';
                }

            } else {
                return "invalid format about ':'";
            }
            }
       
        return $data;
    }
}
