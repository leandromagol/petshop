<?php

declare(strict_types=1);

namespace Leandroo\OrderNotificationPackage;

use Leandroo\OrderNotificationPackage\Events\OrderStatusUpdated;

class NotificationOrderStatusUpdater
{
    public function __construct(public string $order_uuid, public string $new_status, public string $timestamp)
    {
        event(new OrderStatusUpdated($order_uuid, $new_status, $timestamp));
    }
}
