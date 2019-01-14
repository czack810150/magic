<?php

namespace App\Providers;

use App\Http\ViewComposers\FilterComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            [
                'hr.index',
                'payroll.basic.index',
                'payroll.compute.index',
                'hour.index',
                'hour.compute',
                'hour.store.index',
                'employee.performance.index'
            ],
            FilterComposer::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
