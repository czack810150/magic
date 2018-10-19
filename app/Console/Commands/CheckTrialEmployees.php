<?php

namespace App\Console\Commands;

use App\Employee;
use Illuminate\Console\Command;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\TrialEmployeeReviewMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;
use App\Location;

class CheckTrialEmployees extends Command implements ShouldQueue
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:checkTrials {hours=180}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check if any trial employees has finished probation period';

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
        $minimumHour = $this->argument('hours');
        $locations = Location::all();

        foreach($locations as $location)
        {
            $employees = Employee::activeTrialEmployee($location->id)->sortBy('hired');
            $reviews = collect();
            foreach($employees as $e){
                if($e->effectiveHours >= $minimumHour){
                    $reviews->push($e);
                }
        }
        $group = Authorization::group(['admin','hr','dm']);
        if(count($reviews)){
            Mail::to($location->manager)->cc($group)->send(new TrialEmployeeReviewMail($reviews));
        $this->info('Minimum hours: '.$minimumHour.' Employees: '.$reviews->count().' Location:'.$location->name);
        }
        }

    }
}
