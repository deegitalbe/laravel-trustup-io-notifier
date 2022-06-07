<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Commands;

use Illuminate\Console\Command;

class LaravelTrustUpIoNotifierCommand extends Command
{
    public $signature = 'laravel-trustup-io-notifier';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
