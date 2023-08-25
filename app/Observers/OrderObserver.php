<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderStatus;
use Leandroo\OrderNotificationPackage\NotificationOrderStatusUpdater;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->order_status_id != $order->getOriginal('order_status_id')) {
            $orderStatus = OrderStatus::where('uuid',$order->order_status_id)->firstOrFail();
            new NotificationOrderStatusUpdater(
                $order->uuid,
                $orderStatus->title,
                now()
            );
        }
    }
}
