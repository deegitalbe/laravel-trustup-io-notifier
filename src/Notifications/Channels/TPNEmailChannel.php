<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

class TPNEmailChannel extends TPNBaseChannel implements TPNChannelInterface
{
    public function getType(): string
    {
        return 'email';
    }

    public function getMethod(): string
    {
        return 'toTPNEmail';
    }

    public function getRouteMethod(): string
    {
        return 'routeNotificationForTPNEmail';
    }
}
