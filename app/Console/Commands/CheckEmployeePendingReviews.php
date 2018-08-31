<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Employee;
use App\Employee_location;
use App\Events\EmployeePendingReview;


class CheckEmployeePendingReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:pendingReview {conditions*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if any employees are due for performance appraisal.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $conditions = $this->argument('conditions');
        $pendings = Employee::reviewPending($conditions[0],$conditions[1])->where('reviewable',true)->where('notified',false);
       
        if(count($pendings)){
            event(new EmployeePendingReview($pendings));

             foreach($pendings as $p)
                {
                    if(count($p->job_location))
                    {
                        $row = $p->job_location->last();
                        $row->notified = true;
                        $row->save();
                    } else {
                        $EL = Employee_location::create([
                            'employee_id' => $p->id,
                            'location_id' => $p->location_id,
                            'job_id' => $p->job_id,
                            'start' => $p->hired->toDateString(),
                            'end' => null,
                            'review' =>$p->hired->toDateString(),
                            'notified' => true,
                        ]);
                    }
                    
                }


             $this->info($pendings->count());
        } else {
            $this->info('There is no pending review employee.');
        }
        
        
    }
}
