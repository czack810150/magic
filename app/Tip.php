<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hour;
use App\Location;
use Carbon\Carbon;
use App\Payroll_tip;

class Tip extends Model
{
    public static function tipHours($startDate,$location)
    {
        if($location != 0 && $location != 9){
            $startDate = Carbon::createFromFormat('Y-m-d',$startDate)->startOfDay();
            $start = $startDate->toDateString();
            $end = $startDate->addDays(13)->toDateString();
            $hours = Hour::where('start',$start)->where('location_id',$location)->get();   
            $tipHours = 0;
            $payrollTip = Payroll_tip::where('start',$start)->where('location_id',$location)->get();
            foreach($hours as $h)
            {
                if(!$h->employee->job->trial){
                    $tipHours += $h->wk1Effective + $h->wk2Effective + $h->wk1EffectiveCash + $h->wk2EffectiveCash;
                }
                
            }
            if(count($payrollTip)){
                //update
                $payrollTip = $payrollTip->first();
                $payrollTip->hours = $tipHours;
                if(!is_null($payrollTip->tips))
                {
                    $payrollTip->hourlyTip = round($payrollTip->tips / $tipHours,0);
                }
                $payrollTip->save();
                } else { // create new
                    $payrollTip = Payroll_tip::create([
                    'start' => $start,
                    'end' => $end,
                    'location_id' => $location,
                    'hours' => $tipHours,
                    ]);
        }
            return $payrollTip;
        } else {
            return null;
        }
    }

}