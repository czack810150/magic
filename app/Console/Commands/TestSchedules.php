<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TestSchedule;

class TestSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testSchedule:new {content?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new entry in the test schedules table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $schedule;
    public function handle()
    {
        $this->schdule = TestSchedule::create(
            ['content' => $this->argument('content')]
        );
    }
}
