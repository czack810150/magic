<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;

class ScriptController extends Controller
{
    public function fixShared()
    {
    	$employees = [
            347 => 30,
    		627 => 30,
    		669 => 371,
    		600 => 159,
    		668 => 43,
    		515 => 107,//张展鹏
            701 => 107,
    		555 => 282,
            696 => 282,
    		670 => 245,
            546 => 577,
            689 => 96, // 姜超迪
            706 => 96,
            685 => 648, 
            680 => 403,
            683 => 551,
            693 => 517, // 简安妮
            691 => 101, //谢结明

    	];
    	$fixed = array();
    	foreach($employees as $old => $new)
    	{
    		$fix = Shift::where('employee_id',$old)->update(['employee_id' => $new ]);
    		$fixed[] = $fix;
    	}
    	return $fixed;
    }
}
