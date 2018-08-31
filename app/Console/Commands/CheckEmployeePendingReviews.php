<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Employee;
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
        // foreach($pendings as $p)
        // {
        //     $this->info("$p->name,$p->location.name,$p->effectiveHours");
        // }
        if(count($pendings)){
            event(new EmployeePendingReview($pendings));
             $this->info($pendings->count());
        } else {
            $this->info('There is no pending review employee.');
        }
        
        
    }
}
