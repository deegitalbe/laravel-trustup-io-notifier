<?php

namespace Deegitalbe\TrustupProNotifier\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewEventWebhookReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public function __construct(
        public array $log,
        public array $event,
        public array $data
    ) {}

}