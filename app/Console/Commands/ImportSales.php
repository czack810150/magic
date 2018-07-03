<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sale;

class ImportSales extends Command
{
    
    protected $signature = 'import:sales {date} {interval=30}';

    
    protected $description = 'Import sales data via MRS(DiGi POS) API';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        $result = Sale::daySales( $this->argument('date'), $this->argument('interval') );
        $this->info("$result recores have been saved.");
    }
}
