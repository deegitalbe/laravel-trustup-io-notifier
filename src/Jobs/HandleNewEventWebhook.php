<?php

namespace Deegitalbe\TrustupProNotifier\Jobs;

use Deegitalbe\TrustupProNotifier\Events\NewEventWebhookReceived;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class HandleNewEventWebhook implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public array $data
    ) {
    }

    public function handle()
    {
        $log = $this->getLog();
        if (! $log) {
            return; // Throw exception
        }

        $event = $this->getLogEvent();
        if (! $event) {
            return; // Throw exception
        }

        NewEventWebhookReceived::dispatch(
            $log,
            $event,
            $this->data
        );
    }

    public function getLog(): ?array
    {
        $response = Http::acceptJson()
            ->withoutVerifying()
            ->withHeaders([
                'X-App-Name' => config('trustup-pro-notifier.app'),
                'X-App-Key' => config('trustup-pro-notifier.key'),
            ])->get(
                config('trustup-pro-notifier.url').'/api/logs/'.$this->data['log_uuid'],
            );

        if (! $response->ok()) {
            return null; // Throw exception
        }

        return $response->json()['log'] ?? null;
    }

    public function getLogEvent(): ?array
    {
        $response = Http::acceptJson()
            ->withoutVerifying()
            ->withHeaders([
                'X-App-Name' => config('trustup-pro-notifier.app'),
                'X-App-Key' => config('trustup-pro-notifier.key'),
            ])->get(
                config('trustup-pro-notifier.url').'/api/logs/'.$this->data['log_uuid'].'/events/'.$this->data['log_event_uuid'],
            );

        if (! $response->ok()) {
            return null; // Throw exception
        }

        return $response->json()['event'] ?? null;
    }
}
