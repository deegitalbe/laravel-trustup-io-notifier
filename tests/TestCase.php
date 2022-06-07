<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Tests;

use Deegitalbe\LaravelTrustUpIoNotifier\LaravelTrustUpIoNotifierServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Deegitalbe\\LaravelTrustUpIoNotifier\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelTrustUpIoNotifierServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-trustup-io-notifier_table.php.stub';
        $migration->up();
        */
    }
}
