<?php

namespace Deegitalbe\TrustupProNotifier;

use Spatie\LaravelPackageTools\Package;
use Illuminate\Support\Facades\Notification;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Deegitalbe\TrustupProNotifier\Commands\TrustupProNotifierCommand;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNSMSChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNPushChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNEmailChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNLetterChannel;

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
            ->hasMigration('create_notification_log_uuids_table');
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
