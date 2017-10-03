<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Datetime extends Model
{
    
    public static function periods($year)
    {
    	$periods = DB::table('payroll_period')->where('year',$year)->get();
    	$periodOptions = array();
    	foreach($periods as $p){
    		$periodOptions[$p->start] = $p->start.' - '.$p->end;
    	}
    	return $periodOptions;
    }
}
