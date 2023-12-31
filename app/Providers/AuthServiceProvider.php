<?php

namespace App\Providers;

use App\Guards\FirebaseJWTGuard;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::extend('custom_jwt', function (Application $app, $name, array $config) {
            return new FirebaseJWTGuard(
                Auth::createUserProvider($config['provider']), // @phpstan-ignore-line
                $app->make(Request::class)
            );
        });
    }
}
