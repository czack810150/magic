<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SaleAmount;

class ImportSalesAmount extends Command
{
    protected $signature = 'import:salesAmount {date} {interval=60}';    
    protected $description = 'Import sales amount data via MRS(DiGi POS) API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $result = SaleAmount::daySales( $this->argument('date'), $this->argument('interval') );
        $this->info("$result recores have been saved.");
    }
}
