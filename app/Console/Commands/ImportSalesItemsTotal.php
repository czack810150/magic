<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sale;

class ImportSalesItemsTotal extends Command
{
   protected $signature = 'import:salesItemsTotal {date}';

    
    protected $description = 'Import sales items data daily total via MRS(DiGi POS) API';

    
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $result = Sale::dayItemQty( $this->argument('date') );
        $this->info("$result recores have been saved.");
    }
}
