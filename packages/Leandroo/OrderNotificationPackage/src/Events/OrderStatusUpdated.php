<?php

declare(strict_types=1);

namespace Leandroo\OrderNotificationPackage\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public string $order_uuid, public string $new_status, public string $timestamp)
    {
    }
}
