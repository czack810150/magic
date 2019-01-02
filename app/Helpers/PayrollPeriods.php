<?php
namespace App\Helpers;

use Carbon\Carbon;

class PayrollPeriods
{
	public static function dates(int $year)
	{
		$lastYear = $year - 1;
		$lastMonday = Carbon::parse("last monday of december $lastYear");
		$firstMonday = Carbon::parse("first monday of january $year");
		$firstDay = Carbon::create($year,1,1,0,0,0);
		$dt = $firstDay->closest($lastMonday,$firstMonday);


		$dates = [];
		for($i = 0; $i < 27; $i++){
			$dates[$dt->toDateString()] = $dt->toDateString().' - '.$dt->addDays(13)->toDateString();
			$dt->addDay();
		}

		return $dates;
	}
	
}