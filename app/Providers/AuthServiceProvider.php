<?php

declare(strict_types=1);

namespace App\Providers;

use App\Guards\FirebaseJWTGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected array $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::provider('firebase_jwt', function () {
            return new FirebaseJWTAuthProvider();
        });
        Auth::extend('custom_jwt', function ($app, $name, array $config) {
            return new FirebaseJWTGuard(
                Auth::createUserProvider($config['provider']),
                $app->make(Request::class)
            );
        });
    }
}
