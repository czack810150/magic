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


    public static function payrollComputeKitchen($startDate,$location){
      
        $periodStart =  $startDate;
        $startDate = Carbon::createFromFormat('Y-m-d',$startDate,'America/Toronto')->startOfDay();
        $config = DB::table('payroll_config')->where('year',$startDate->year)->first();
     
        $wk1Start = $startDate->toDateString();
        $wk1End = $startDate->addDays(6)->toDateString();
        $wk2Start = $startDate->addDay()->toDateString();
        $wk2End = $startDate->addDays(6)->toDateString();
        $employeeHours = Hour::where('start',$periodStart)->where('location_id',$location)->get();
        $count = 0;
        foreach($employeeHours as $e){
         
            $hourlyTip = 0;
           
            $e->effectiveHour = $e->wk1Effective + $e->wk2Effective; // effective hours
            $e->nightHour = $e->wk1Night + $e->wk2Night + $e->wk1NightCash + $e->wk2NightCash; // night hours
            $e->cashHour = $e->wk1EffectiveCash + $e->wk2EffectiveCash; // cash hours

            //holidays
            $premiumPay = 0;
            $holidayPay = 0;
            $holidays = Holiday::whereBetween('date',[$wk1Start,$wk2End])->get();
            if(count($holidays)){
                foreach($holidays as $holiday){
                        $holidayPay += self::fourWeekHolidayPay($e->employee_id,$e->location_id,$e->employee->job->rate/100,$holiday->date,$periodStart);
                }
            } 

            // Performance index
            $performance = Score_log::where('location_id',$e->location_id)->where('employee_id',$e->employee_id)->
                            whereBetween('date',[$periodStart,$wk2End])->sum('value') + 100;
            if($performance > 110)
                $performance = 110; 

            $performance /= 100;
            $bonus = 0;

            $e->kitchenPay = self::kitchenPay(
                                        Carbon::now()->year,
                                        $e->employee->job->rate,
                                        $e->wk1Effective,
                                        $e->wk2Effective,
                                        $e->cashHour,
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

                $log->rate = $e->employee->job->rate;

                $log->week1 = $e->wk1Effective;
                $log->week2 = $e->wk2Effective;
                $log->ot1 = $e->wk1Overtime;
                $log->ot2 = $e->wk2Overtime;
                $log->regularPay = $e->kitchenPay->grossPay->regularPay*100;
                $log->overtimePay = $e->kitchenPay->grossPay->overtimePay*100;
                $log->grossIncome = $e->kitchenPay->grossPay->total*100;

                $log->vacationPay = $e->kitchenPay->grossPay->total * 0.04 * 100;
                $log->EI = $e->kitchenPay->basicPay->EI *100;
                $log->CPP = $e->kitchenPay->basicPay->CPP *100;
                $log->federalTax = $e->kitchenPay->basicPay->federalTax *100;
                $log->provincialTax = $e->kitchenPay->basicPay->provincialTax *100;
                $log->cheque = $e->kitchenPay->basicPay->net *100;
                $log->position_rate = 0;
                $log->tip = 0;
                $log->hourlyTip = 0;
                $log->mealRate = 0;
                $log->nightRate = $e->kitchenPay->variablePay->nightRate *100;
                $log->nightHours = $e->kitchenPay->variablePay->nightHours;
                $log->performance = $e->kitchenPay->variablePay->performanceIndex;
                $log->bonus = $e->kitchenPay->variablePay->bonus *100;
                $log->variablePay = $e->kitchenPay->variablePay->total *100;
                $log->totalPay = $log->cheque*100 + $log->variablePay*100 + $e->kitchenPay->cashPay;
                $log->holidayPay = $holidayPay*100;
                $log->premiumPay = $premiumPay*100;
                $log->cashPay = $e->kitchenPay->cashPay;
                $log->cashHour = $e->cashHour;
                $log->save();
                $count += 1;
            }
        }
        return $count;
    }


    private static function  kitchenPay($year,$rate,$wk1Hr,$wk2Hr,$cashHour,$nightHours,$performanceIndex,$bonus,$holidayPay,$premiumPay){

        $config = DB::table('payroll_config')->where('year',$year)->first();
        $mealRate = 0;
        $nightRate = $config->nightRate;
        $vacationPayRate = $config->vacation_pay;

        $hours = $wk1Hr + $wk2Hr;
        $twoWeekGrossPay = self::twoWeekGrossPayKitchen($year,$rate/100,$wk1Hr,$wk2Hr,$holidayPay,$premiumPay);
        $vacationPay = round($twoWeekGrossPay->total * $vacationPayRate,2);
        $grossPayWithVacationPay = $twoWeekGrossPay->total + $vacationPay ; // vacation pay included for calculating deductibles
        $basicPay = Cra::payStub($grossPayWithVacationPay,null,null,26,$year,'ON',1);
        $variablePay = self::variablePay($hours+$cashHour,0,0,0,0,$nightRate,$nightHours,$performanceIndex,$bonus);
        //$cashRate = $config->cashPay;
        $cashPay = self::cashPay($cashHour,$rate);

        $kitchenPay = new MagicNoodlePay($twoWeekGrossPay,$basicPay,$variablePay,$cashPay);

        return $kitchenPay;
    }
    public static function twoWeekGrossPayKitchen($year,$rate,$wk1Hr,$wk2Hr,$holidayPay,$premiumPay){
        $config = DB::table('payroll_config')->where('year',$year)->first();
        $regular = 0; // regular hours worked
        $overtime1 = self::overtime($wk1Hr,$year);
        $overtime2 = self::overtime($wk2Hr,$year);
        $regular += $wk1Hr - $overtime1;
        $regular += $wk2Hr - $overtime2;
        $rp = round($regular * $rate,2); // pay for regular hours
        $op =  round(($overtime1 + $overtime2) * $rate * $config->overtime_pay,2); // pay for overtime hours
        $total = $rp + $op + $holidayPay + $premiumPay;
        // $total = $rp + $op;

        return new GrossIncome($wk1Hr,$wk2Hr,$rate,$overtime1,$overtime2,$rp,$op,$total,$holidayPay);
        
    }