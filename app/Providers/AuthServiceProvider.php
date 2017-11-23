<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('calculate-hours',function($user) {
            return $user->authorization->type == 'admin';
        });

        Gate::define('calculate-payroll',function($user){
            return $user->authorization->type == 'admin';
        });

        Gate::define('score-employee',function($user){
            return in_array($user->authorization->type,['admin','manager','dm']);
        });
    }
}
