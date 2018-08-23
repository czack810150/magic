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
        
        'App\Events\EmployeeAdded' => [
            'App\Listeners\SendEmployeeAddedNotification',
            'App\Listeners\EmployeeWelcomeListener'
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
        'App\Events\LeaveRequested' => [
            'App\Listeners\LeaveRequestedListener',
        ],
        'App\Events\LeaveApproved' => [
            'App\Listeners\LeaveApprovedListener',
        ],
        'App\Events\LeaveRejected' => [
            'App\Listeners\LeaveRejectedListener',
        ],
        'App\Events\EmailConfirmed' => [
            'App\Listeners\EmailConfirmedListener'
        ],
        'App\Events\ExamCreated' => [
            'App\Listeners\ExamCreatedListener',
        ],
        'App\Events\ExamSubmitted' => [
            'App\Listeners\ExamSubmittedListener',
        ],
        'App\Events\ShiftsPublished' => [
            'App\Listeners\ShiftsPublishedListener',
        ],
        'App\Events\EmployeeToBeTerminated' => [
            'App\Listeners\EmployeeToBeTerminatedListener',
        ]
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
