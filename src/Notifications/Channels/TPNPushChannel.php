<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

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