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
<<<<<<< HEAD
    		515 => 107,//张展鹏
            701 => 107,
=======
    		515 => 107,
            712 => 107,
>>>>>>> a9fc77ad3cf7512abb1408f0691c88a44fa5130d
    		555 => 282,
            696 => 282,
    		670 => 245,
            546 => 577,
            689 => 96, // 姜超迪
            706 => 96,
            685 => 648, 
            680 => 403,
            683 => 551,
<<<<<<< HEAD
            693 => 517, // 简安妮
            691 => 101, //谢结明
=======
            582 => 521,
>>>>>>> a9fc77ad3cf7512abb1408f0691c88a44fa5130d

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
