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
            return in_array($user->authorization->type,['admin','accounting']);
        });

        Gate::define('calculate-payroll',function($user){
            return in_array($user->authorization->type,['admin','accounting']);
        });
        Gate::define('workon-tips',function($user){
            return in_array($user->authorization->type,['admin','accounting']);
        });
        Gate::define('score-employee',function($user){
            return in_array($user->authorization->type,['admin','manager','dm']);
        });

        Gate::define('create-employee',function($user){
            return in_array($user->authorization->type,['admin','hr','dm']);
        });

        Gate::define('view-employee',function($user,$employee){
            if( $user->authorization->type == 'employee' ){
                return $user->authorization->employee_id == $employee->id;
            } else {
                return true;
            }
        });
        Gate::define('view-allEmployee',function($user){
            return in_array($user->authorization->type,['admin','hr','dm','gm','accounting']);
        });
        Gate::define('note-employee',function($user){
             return in_array($user->authorization->type,['admin','manager','dm','gm','accounting']);
        });
        Gate::define('update-employment',function($user){
             return in_array($user->authorization->type,['admin','hr','dm','manager','accounting']);
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
        Gate::define('assign-skill',function($user){
            return true;
        });
        Gate::define('view-hr',function($user){
            return in_array($user->authorization->type,['hr','dm','manager','accounting','gm','admin']);
        });
        Gate::define('use-scheduler',function($user){
            return in_array($user->authorization->type,['dm','admin','manager','gm','accounting']);
        });
        Gate::define('canBePromoted',function($user){
            return in_array($user->authorization->type,['employee','admin']);
        });
        Gate::define('promote-employee',function($user){
            return in_array($user->authorization->type,['hr','dm','admin']);
        });
        Gate::define('update-salary',function($user){
            return in_array($user->authorization->type,['hr','dm','admin','accounting']);
        });
        Gate::define('assign-skill',function($user){
            return in_array($user->authorization->type,['hr','dm','admin','manager']);
        });
        Gate::define('configure-app',function($user){
            return in_array($user->authorization->type,['dm','admin']);
        });
        Gate::define('create-team',function($user){
            return in_array($user->authorization->type,['dm','admin']);
        });
        Gate::define('is-admin',function($user){
            return in_array($user->authorization->type,['admin']);
        });
        Gate::define('view-sales',function($user){
            return in_array($user->authorization->type,['admin','dm','manager','gm','accounting']);
        });
        Gate::define('view-reviews', function($user){
            return in_array($user->authorization->type,['admin','dm','manager','gm','accounting']);
        });
    }
}
