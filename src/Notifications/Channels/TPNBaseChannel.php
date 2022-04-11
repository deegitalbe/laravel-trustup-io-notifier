<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

abstract class TPNBaseChannel
{
    public function getTo(array $message, $notifiable): ?string
    {
        if (isset($message['to']) && $message['to']) {
            return $message['to'];
        }

        if ($notifiable && method_exists($notifiable, $this->getRouteMethod())) {
            return $notifiable->{$this->getRouteMethod()}($this);
        }

        return null;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $method = $this->getMethod();
        $message = $notification->{$method}($notifiable);

        if (! isset($message['uuid'])) {
            $message['uuid'] = (string) Uuid::uuid4();
        }

        $response = Http::acceptJson()
            ->withoutVerifying()
            ->withHeaders([
                'X-App-Name' => config('trustup-pro-notifier.app'),
                'X-App-Key' => config('trustup-pro-notifier.key'),
            ])->post(
                config('trustup-pro-notifier.url').'/api/notify/'.$this->getType(),
                array_merge(
                    $message,
                    [
                        'to' => $this->getTo($message, $notifiable),
                        'notifiable_id' => optional($notifiable)->id,
                        'notifiable_type' => optional($notifiable)->getMorphClass(),
                        'notification_class' => get_class($notification),
                    ]
                )
            );

        if (! $response->ok()) {
            throw new Exception('Could not send notification ['.$this->getType().'] via ' . config('trustup-pro-notifier.url'));
        }

        if (Schema::hasTable('notification_log_uuids')) {
            DB::table('notification_log_uuids')->insert([
                'notification_id' => $notification->id,
                'driver' => $this->getType(),
                'uuid' => $message['uuid'],
            ]);
        }
    }
}
