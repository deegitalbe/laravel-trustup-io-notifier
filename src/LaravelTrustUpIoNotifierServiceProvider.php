<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Illuminate\Support\Facades\Notification;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Deegitalbe\LaravelTrustUpIoNotifier\Events\NewEventWebhookReceived;
use Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels\TPNSMSChannel;
use Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels\TPNPushChannel;
use Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels\TPNEmailChannel;
use Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels\TPNSlackChannel;
use Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels\TPNLetterChannel;

class LaravelTrustUpIoNotifierServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-trustup-io-notifier')
            ->hasConfigFile()
            ->hasMigration('create_notification_log_uuids_table')
            ->hasRoute('webhooks');
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

        Notification::extend('tpn_slack', function ($app) {
            return new TPNSlackChannel();
        });

        if (config('trustup-io-notifier.webhooks.new-event.enabled')) {
            Event::listen(
                NewEventWebhookReceived::class,
                [config('trustup-io-notifier.webhooks.new-event.listener'), 'handle']
            );
        }
    }
}
