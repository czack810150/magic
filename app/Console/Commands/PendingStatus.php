<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Employee;
use App\EmployeePending;
use Carbon\Carbon;

class PendingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pendingStatus:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update employees\' pending status change';

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
        $dt = Carbon::now();
        $pendingStarts = EmployeePending::whereDate('start','=',$dt->toDateString())->get();
        $count = 0;
        if(count($pendingStarts))
        {
            foreach($pendingStarts as $p)
            {
                $p->employee->status = $p->status;
                $p->employee->save();
                $count++;
            }
        }

        $pendingEnds = EmployeePending::whereDate('end','=',$dt->subDay()->toDateString())->get();
        if(count($pendingEnds))
        {
            foreach($pendingEnds as $pe)
            {
                $pe->employee->status = 'active';
                $pe->employee->save();
                $count++;
            }
        }


        $this->info("$count status changes have been saved.");
    }
}
