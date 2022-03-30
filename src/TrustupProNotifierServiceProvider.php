<?php

namespace Deegitalbe\TrustupProNotifier;

use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNEmailChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNLetterChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNPushChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNSMSChannel;
use Illuminate\Support\Facades\Notification;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TrustupProNotifierServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('trustup-pro-notifier')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('notification_log_uuids');
    }

    public function packageBooted()
    {
        Notification::extend('tpn_sms', function ($app) {
            return new TPNSMSChannel();
        });

        Notification::extend('tpn_email', function ($app) {
            return new TPNEmailChannel();
        });

        Notification::extend('tpn_letter', function ($app) {
            return new TPNLetterChannel();
        });

        Notification::extend('tpn_push', function ($app) {
            return new TPNPushChannel();
        });
    }
}
