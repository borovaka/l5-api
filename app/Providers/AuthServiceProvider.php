<?php

namespace App\Providers;

use App\ApiService\ApiGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function boot(Request $request)
    {
        $this->registerPolicies();

        Auth::extend('api', function ($app, $name, array $config) use ($request) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...
            return new ApiGuard(Auth::createUserProvider($config['provider']), $request);
        });

        //
    }
}
