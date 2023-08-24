<?php
namespace Leandroo\OrderNotificationPackage\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
class OrderStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param string $order_uuid
     * @param string $new_status
     * @param string $timestamp
     * @return void
     */
    public function __construct(public string $order_uuid, public string $new_status, public string $timestamp)
    {

    }
}
