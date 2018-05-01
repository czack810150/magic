<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\LeaveRequested' => [
            'App\Listeners\LeaveRequestedListener',
        ],
        'App\Events\EmployeeAdded' => [
            'App\Listeners\SendEmployeeAddedNotification',
        ],
        'App\Events\PromotionRequested' => [
            'App\Listeners\PromotionRequestListener',
        ],
        'App\Events\PromotionApproved' => [
            'App\Listeners\PromotionApprovedListener',
        ],
        'App\Events\PromotionRejected' => [
            'App\Listeners\PromotionRejectedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
