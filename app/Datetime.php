<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Datetime extends Model
{
    
    public static function periods($year)
    {
    	//$periods = DB::table('payroll_period')->where('year',$year)->get();
    	$periods = DB::table('payroll_period')->where('year',2017)->get();
    	$periodOptions = array();
    	foreach($periods as $p){
    		$periodOptions[$p->start] = $p->start.' - '.$p->end;
    	}
    	return $periodOptions;
    }
}
