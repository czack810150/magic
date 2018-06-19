<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sale;

class ImportSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sales {date} {interval=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import sales data via MRS(DiGi POS) API';

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
        $result = Sale::daySales( $this->argument('date'), $this->argument('interval') );
        $this->info("$result recores have been saved.");
    }
}
