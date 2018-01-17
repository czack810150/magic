<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
}
