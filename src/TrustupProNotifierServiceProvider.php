<?php

namespace Deegitalbe\TrustupProNotifier;

use Deegitalbe\TrustupProNotifier\Events\NewEventWebhookReceived;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNEmailChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNLetterChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNPushChannel;
use Deegitalbe\TrustupProNotifier\Notifications\Channels\TPNSMSChannel;
use Illuminate\Support\Facades\Event;
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

        if (config('trustup-pro-notifier.webhooks.new-event.enabled')) {
            Event::listen(
                NewEventWebhookReceived::class,
                [config('trustup-pro-notifier.webhooks.new-event.listener'), 'handle']
            );
        }
    }
}
