<?php

namespace Leandroo\OrderNotificationPackage\tests;

use Tests\TestCase;
use Leandroo\OrderNotificationPackage\Events\OrderStatusUpdated;

class OrderStatusUpdatedTest extends TestCase
{
    /** @test */
    public function it_can_be_constructed_with_properties()
    {
        $orderUuid = 'order-123';
        $newStatus = 'shipped';
        $timestamp = '2023-08-23 12:34:56';

        $event = new OrderStatusUpdated($orderUuid, $newStatus, $timestamp);

        $this->assertInstanceOf(OrderStatusUpdated::class, $event);
        $this->assertEquals($orderUuid, $event->order_uuid);
        $this->assertEquals($newStatus, $event->new_status);
        $this->assertEquals($timestamp, $event->timestamp);
    }
}
