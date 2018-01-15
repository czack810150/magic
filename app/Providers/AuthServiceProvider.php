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
        Gate::define('workon-tips',function($user){
            return in_array($user->authorization->type,['admin','accounting']);
        });
        Gate::define('score-employee',function($user){
            return in_array($user->authorization->type,['admin','manager','dm']);
        });

        Gate::define('create-employee',function($user){
            return in_array($user->authorization->type,['admin','hr']);
        });

        Gate::define('view-employee',function($user,$employee){
            if( $user->authorization->type == 'employee' ){
                return $user->authorization->employee_id == $employee->id;
            } else {
                return true;
            }
        });
        Gate::define('note-employee',function($user){
             return in_array($user->authorization->type,['admin','manager','dm','gm','accounting']);
        });
        Gate::define('update-employment',function($user){
             return in_array($user->authorization->type,['admin','hr','dm','accounting']);
        });
        Gate::define('update-background',function($user,$employee){
             return in_array($user->authorization->type,['admin','hr','dm','accounting']) || $user->authorization->employee_id == $employee->id;
        });
        Gate::define('can-clockin',function($user){
            return $user->authorization->type == 'location';
        });
        Gate::define('manage-managers',function($user){
            return in_array($user->authorization->type,['admin','dm','gm','accounting']);
        });
        Gate::define('is-management',function($user){
            return in_array($user->authorization->type,['admin','manager','dm','gm','accounting']);
        });
        Gate::define('update-profile-picture',function($user,$employee){
            return in_array($user->authorization->type,['admin','hr','dm','manager']) || $user->authorization->employee_id == $employee;
        });
    }
}
