
            // $e->wk1Holidays = Holiday::whereBetween('date',[$wk1Start,$wk1End])->get();
            // $e->wk2Holidays = Holiday::whereBetween('date',[$wk2Start,$wk2End])->get();
            // if(sizeof($e->wk1Holidays)){
            // foreach($e->wk1Holidays as $holiday){
            //         $dt2 = Carbon::createFromFormat('Y-m-d',$holiday->date);
            //         $fourWeekEnd = $dt2->startOfWeek()->subDay()->toDateString();
            //         $fourWeekStart = $dt2->subWeeks(4)->addDay()->toDateString();
            //         $e->wk1Holidays->start =  $fourWeekStart;
            //         $e->wk1Holidays->end =  $fourWeekEnd;
            //         $fourWeekHours = Hour::effectiveHour($e->employee_id,$e->location_id,$fourWeekStart,$fourWeekEnd)['hours'];
            //         $holidayPay  += round($fourWeekHours * $basicRate * 1.00 / 20,2);
            //         // remove premium pay for now
            //         // if($fourWeekHours){
            //         //     $premiumPay += Hour::effectiveHour($e->employee_id,$e->location_id,$holiday->date,$holiday->date)['hours'] * $basicRate * .5;
            //         // }

            //     }}

             // if(sizeof($e->wk2Holidays)){
             // foreach($e->wk2Holidays as $holiday){
             //        $dt2 = Carbon::createFromFormat('Y-m-d',$holiday->date);
             //        $fourWeekEnd = $dt2->startOfWeek()->subDay()->toDateString();
             //        $fourWeekStart = $dt2->subWeeks(4)->addDay()->toDateString();
             //         $e->wk2Holidays->start =  $fourWeekStart;
             //        $e->wk2Holidays->end =  $fourWeekEnd;
             //        $fourWeekHours = Hour::effectiveHour($e->employee_id,$e->location_id,$fourWeekStart,$fourWeekEnd)['hours'];
             //        $holidayPay  += round($fourWeekHours * $basicRate * 1.00 / 20,2);
             //        // remove ppremium pay for now 2018-01-02
             //        // if($fourWeekHours){
             //        //     $premiumPay += Hour::effectiveHour($e->employee_id,$e->location_id,$holiday->date,$holiday->date)['hours'] * $basicRate * .5;
             //        // }

             //    }} 
           // $holidayPay  = round($fourWeekHours * $basicRate * 1.04 / 20,2);