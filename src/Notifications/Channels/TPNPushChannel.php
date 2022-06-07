<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels;

class TPNPushChannel extends TPNBaseChannel implements TPNChannelInterface
{
    public function getType(): string
    {
        return 'push';
    }

    public function getMethod(): string
    {
        return 'toTPNPush';
    }

    public function getRouteMethod(): string
    {
        return 'routeNotificationForTPNPush';
    }
}
