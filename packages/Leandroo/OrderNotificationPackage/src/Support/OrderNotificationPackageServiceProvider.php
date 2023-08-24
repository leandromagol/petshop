<?php

declare(strict_types=1);

namespace Leandroo\OrderNotificationPackage\Support;

use Illuminate\Support\ServiceProvider;

class OrderNotificationPackageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/order-notification-package.php',
            'order-notification-package'
        );
    }

    public function boot(): void
    {
        $this->app['events']->listen(
            'Leandroo\OrderNotificationPackage\Events\OrderStatusUpdated',
            'Leandroo\OrderNotificationPackage\Listeners\SendWebhookNotification'
        );
        $this->publishes([
            __DIR__.'/../config/order-notification-package.php' => config_path('order-notification-package.php'),
        ], 'order-notification-package-config');
    }
}
