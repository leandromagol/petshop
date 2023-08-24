<?php

namespace Leandroo\OrderNotificationPackage\Listeners;

use Leandroo\OrderNotificationPackage\Events\OrderStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendWebhookNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  OrderStatusUpdated  $event
     * @return void
     */
    public function handle(OrderStatusUpdated $event)
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
