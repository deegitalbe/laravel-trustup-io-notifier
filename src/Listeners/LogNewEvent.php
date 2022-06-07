<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Listeners;

use Deegitalbe\LaravelTrustUpIoNotifier\Events\NewEventWebhookReceived;

class LogNewEvent
{
    /**
     * Do what you want here. The package can't do this for you because it is dependant on your app's need (if any).
     * If you have no need for this, you should set the 'enabled' option to false in the config/laravel-trustup-io-notifier.php file.
     */
    public function handle(NewEventWebhookReceived $event)
    {
    }
}
