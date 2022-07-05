<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->define('access-user', function ($user) {
            $array = array('admin','user');
            if(in_array(strtolower($user->role),array_map('strtolower',$array))) {  return true; }
        });

        $gate->define('access-admin', function ($user) {
            $array = array('admin');
            if(in_array(strtolower($user->role),array_map('strtolower',$array))) {  return true; }
        });
    }
}
