<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

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