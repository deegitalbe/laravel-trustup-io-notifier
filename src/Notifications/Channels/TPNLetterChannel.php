<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

class TPNLetterChannel extends TPNBaseChannel implements TPNChannelInterface
{
    public function getType(): string
    {
        return 'letter';
    }

    public function getMethod(): string
    {
        return 'toTPNLetter';
    }

    public function getRouteMethod(): string
    {
        return 'routeNotificationForTPNLetter';
    }
}
