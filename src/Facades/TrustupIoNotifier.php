<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Deegitalbe\LaravelTrustUpIoNotifier\LaravelTrustUpIoNotifier
 */
class LaravelTrustUpIoNotifier extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-trustup-io-notifier';
    }
}
