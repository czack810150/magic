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
}
