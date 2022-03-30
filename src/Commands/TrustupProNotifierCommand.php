<?php

namespace Deegitalbe\TrustupProNotifier\Commands;

use Illuminate\Console\Command;

class TrustupProNotifierCommand extends Command
{
    public $signature = 'trustup-pro-notifier';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
