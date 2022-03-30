<?php

namespace Deegitalbe\TrustupProNotifier\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Deegitalbe\TrustupProNotifier\TrustupProNotifier
 */
class TrustupProNotifier extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'trustup-pro-notifier';
    }
}
