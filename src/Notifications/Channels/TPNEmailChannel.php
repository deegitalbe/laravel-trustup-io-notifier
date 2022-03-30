<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

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