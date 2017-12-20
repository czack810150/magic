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
            525 => 30,
            593 => 30,
    		627 => 30,
            702 => 30,
            705 => 30,
    		669 => 371,
    		600 => 159,
    		668 => 43,
    		515 => 107,
            712 => 107,
    		555 => 282,
            696 => 282,
    		670 => 245,
            546 => 577,
            689 => 96,
            685 => 648, 
            680 => 403,
            683 => 551,
            582 => 521,

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
