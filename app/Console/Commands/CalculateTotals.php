<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sale;


class CalculateTotals extends Command
{
    
    protected $signature = 'calculate:total {date}';

    
    protected $description = 'Calculate Daily sales totals';

   
    public function __construct()
    {
        parent::__construct();
    }

  
    public function handle()
    {
        return Sale::saveDailySales($this->argument('date'));
    }
}
