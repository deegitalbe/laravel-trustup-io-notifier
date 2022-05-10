<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

abstract class TPNBaseChannel
{
    public function getTo(array $message, $notifiable, Notification $notification): ?string
    {
        if (isset($message['to']) && $message['to']) {
            return $message['to'];
        }

        if ($notifiable instanceof AnonymousNotifiable) {
            return $notifiable->routes['tpn_'.$this->getType()];
        }

        if ($notifiable && method_exists($notifiable, $this->getRouteMethod())) {
            return $notifiable->{$this->getRouteMethod()}($notification);
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
        $message = $this->transformMessageToArray($notification, $message);

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
                $this->getBody($message, $notification, $notifiable)
            );

        if (! $response->ok()) {
            throw new Exception('Could not send notification ['.$this->getType().'] via ' . config('trustup-pro-notifier.url'));
        }

        if (! Schema::hasTable('notification_log_uuids')) {
            return;
        }

        DB::table('notification_log_uuids')->insert([
            'notification_id' => $notification->id,
            'driver' => $this->getType(),
            'uuid' => $message['uuid'],
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);
    }

    public function transformMessageToArray($notification, $message): array
    {
        return $message;
    }

    public function getBody($message, $notification, $notifiable): array
    {
        return array_merge(
            $message,
            [
                'to' => $this->getTo($message, $notifiable, $notification),
                'notifiable_id' => $this->getNotifiableId($notifiable),
                'notifiable_type' => $this->getNotifiableType($notifiable),
                'notification_class' => get_class($notification),
            ]
        );
    }

    public function getNotifiableId($notifiable)
    {
        return $notifiable instanceof Model
            ? $notifiable->id
            : null;
    }

    public function getNotifiableType($notifiable)
    {
        return $notifiable instanceof Model
            ? $notifiable->getMorphClass()
            : get_class($notifiable);
    }
}
