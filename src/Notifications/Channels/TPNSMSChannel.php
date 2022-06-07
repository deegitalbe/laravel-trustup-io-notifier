<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels;

class TPNSMSChannel extends TPNBaseChannel implements TPNChannelInterface
{
    public function getType(): string
    {
        return 'sms';
    }

    public function getMethod(): string
    {
        return 'toTPNSMS';
    }

    public function getRouteMethod(): string
    {
        return 'routeNotificationForTPNSMS';
    }
}
