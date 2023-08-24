# Laravel Package: Order Status Notifications to Microsoft Teams

This Laravel package provides an easy way to send order status update notifications to Microsoft Teams via webhooks. 
It utilizes Laravel's Events and Listeners system to trigger notifications when an order's status changes.
## Configuration
Publish the package's configuration file:

```bash
php artisan vendor:publish --tag=order-notification-package-config
```
Open the published configuration file at config/order-notification-package.php and set your MS Teams webhook URL:

```bash
return [
    'webhook_url' => env('TEAMS_WEBHOOK_URL', ''),
];
```

## Usage
### Triggering Order Status Update Event
Inside your application's code where an order's status updates, trigger the OrderStatusUpdated event with the relevant 
information:

```bash
use App\Events\OrderStatusUpdated;

$orderUuid = 'your_order_uuid_here';
$newStatus = 'new_status_here';
$timestamp = now(); // Current timestamp

event(new OrderStatusUpdated($orderUuid, $newStatus, $timestamp));

```
###Sending Teams Notification
The SendTeamsNotification listener will automatically handle sending the Teams notification when the OrderStatusUpdated
event is triggered. The listener will use the configured MS Teams webhook URL to send the notification.
