<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

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
