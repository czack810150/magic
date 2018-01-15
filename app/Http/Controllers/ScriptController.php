<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;

class ScriptController extends Controller
{
    public function fixShared()
    {
    	$employees = [
            347 => 30, //赵少斌 4
    		627 => 30, // 1
            702 => 30, // 2
    		669 => 371,
    		600 => 159,//魏朝北
            636 => 43,
            537 => 43,
            514 => 43,
            341 => 43,
    		668 => 43,
            694 => 43,//林友青
    		515 => 107,//张展鹏
            701 => 107,
            712 => 107,
    		555 => 282,
            696 => 282,
    		670 => 245,
            546 => 577, //张圣宇
            133 => 577,
            546 => 577,
            730 => 577,
            689 => 96, // 姜超迪
            706 => 96,
            685 => 648, 
            680 => 403,
            683 => 551,
            693 => 517, // 简安妮
            691 => 101, //谢结明
            582 => 521,
            713 => 551, //沈梦圆
            684 => 551,
            683 => 551,
            680 => 403, // 邹建辉
            744 => 709, //馮翊維
            740 => 486, //黄存久
            742 => 716, //解志坚
            744 => 709, // 馮翊維
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
