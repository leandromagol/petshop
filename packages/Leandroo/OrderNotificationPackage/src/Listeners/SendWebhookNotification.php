<?php

declare(strict_types=1);

namespace Leandroo\OrderNotificationPackage\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Leandroo\OrderNotificationPackage\Events\OrderStatusUpdated;

class SendWebhookNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event): void
    {
        $webhookUrl = config('order-notification-package.webhook_url');
        $notificationCard = [
            'title' => 'Order Status Updated',
            'text' => "Order {$event->order_uuid} status has been updated to {$event->new_status}.",
            'timestamp' => $event->timestamp,
        ];

        Http::post($webhookUrl, [
            'type' => 'message',
            'attachments' => [$notificationCard],
        ]);
    }
}
