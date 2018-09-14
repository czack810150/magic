<?php
public static function payrollCompute($startDate,$location)
    {

        $periodStart =  $startDate;
        $startDate = Carbon::createFromFormat('Y-m-d',$startDate,'America/Toronto')->startOfDay();
        $config = DB::table('payroll_config')->where('year',$startDate->year)->first();
        $basicRate = $config->minimumPay/100;
        $wk1Start = $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();
        if($location == 'all'){
          
             $employeeHours = Hour::where('start',$periodStart)->get();
        } else {

             $employeeHours = Hour::where('start',$periodStart)->where('location_id',$location)->get();
        }

        $count = 0;
        foreach($employeeHours as $e)
        {
            $hourlyTip = Payroll_tip::where('start',$periodStart)->where('location_id',$e->location_id)->first();
            if($hourlyTip){
                $hourlyTip = $hourlyTip->hourlyTip;
            } else {
                $hourlyTip = 0;
            }
            $e->effectiveHour = $e->wk1Effective + $e->wk2Effective; // effective hours
            $e->nightHour = $e->wk1Night + $e->wk2Night + $e->wk1NightCash + $e->wk2NightCash; // night hours
            $e->cashHour = $e->wk1EffectiveCash + $e->wk2EffectiveCash; // cash hours

            //holidays
            $premiumPay = 0;
            $holidayPay = 0;
            $holidays = Holiday::whereBetween('date',[$wk1Start,$wk2End])->get();
            if(count($holidays)){
                foreach($holidays as $holiday){
                    $holidayPay += self::fourWeekHolidayPay($e->employee_id,$e->location_id,$config->minimumPay/100,$holiday->date,$periodStart); 

                }
            } 

            // Performance index
            // $performance = Score_log::where('location_id',$e->location_id)->where('employee_id',$e->employee_id)->
            //                 whereBetween('date',[$periodStart,$wk2End])->sum('value') + 100;
            // if($performance > 110)
            //     $performance = 110; 

            // $performance /= 100;
            $performance = 1.0;
            $bonus = 0;

            $e->magicNoodlePay = self::magicNoodlePay(
                                        Carbon::now()->year,
                                        $e->wk1Effective,
                                        $e->wk2Effective,
                                        $e->cashHour,
                                        $e->employee->job->rate/100,
                                        $e->employee->job->tip,
                                        $hourlyTip,
                                        $e->nightHour,
                                        $performance,
                                        $bonus,$holidayPay,
                                        $premiumPay
                                        );
            // save to payroll log
            if($e->effectiveHour > 0 || $e->cashHour > 0){
                // save to db
                $log = new Payroll_log();
                $log->startDate = $e->start;
                $log->endDate = $e->end;
                $log->location_id = $e->location_id;
                $log->employee_id = $e->employee_id;
                $log->rate = $e->magicNoodlePay->grossPay->basicRate*100;
                $log->week1 = $e->magicNoodlePay->grossPay->week1Hour;
                $log->week2 = $e->magicNoodlePay->grossPay->week2Hour;
                $log->ot1 = $e->wk1Overtime;
                $log->ot2 = $e->wk2Overtime;
                $log->regularPay = $e->magicNoodlePay->grossPay->regularPay*100;
                $log->overtimePay = $e->magicNoodlePay->grossPay->overtimePay*100;
                $log->grossIncome = $e->magicNoodlePay->grossPay->total*100;
                $log->vacationPay = $e->magicNoodlePay->grossPay->total * 0.04 * 100;
                $log->EI = $e->magicNoodlePay->basicPay->EI *100;
                $log->CPP = $e->magicNoodlePay->basicPay->CPP *100;
                $log->federalTax = $e->magicNoodlePay->basicPay->federalTax *100;
                $log->provincialTax = $e->magicNoodlePay->basicPay->provincialTax *100;
                $log->cheque = $e->magicNoodlePay->basicPay->net *100;
                $log->position_rate = $e->magicNoodlePay->variablePay->positionRate *100;
                $log->tip = $e->magicNoodlePay->variablePay->tipRate;
                $log->hourlyTip = $e->magicNoodlePay->variablePay->hourlyTip *100;
                $log->mealRate = $e->magicNoodlePay->variablePay->mealRate *100;
                $log->nightRate = $e->magicNoodlePay->variablePay->nightRate *100;
                $log->nightHours = $e->magicNoodlePay->variablePay->nightHours;
                $log->performance = $e->magicNoodlePay->variablePay->performanceIndex;
                $log->bonus = $e->magicNoodlePay->variablePay->bonus *100;
                $log->variablePay = $e->magicNoodlePay->variablePay->total *100;
                $log->totalPay = $log->cheque*100 + $log->variablePay*100 + $e->magicNoodlePay->cashPay;
                $log->holidayPay = $holidayPay*100;
                $log->premiumPay = $premiumPay*100;
                $log->cashPay = $e->magicNoodlePay->cashPay;
                $log->cashHour = $e->cashHour;
                $log->save();
                $count += 1;
            }
        }
        return $count;
    }