<?php

namespace Deegitalbe\TrustupProNotifier;

use Deegitalbe\TrustupProNotifier\Commands\TrustupProNotifierCommand;
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
            ->hasMigration('create_trustup-pro-notifier_table')
            ->hasCommand(TrustupProNotifierCommand::class);
    }
}
