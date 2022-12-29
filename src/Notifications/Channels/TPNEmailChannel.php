<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels;

use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;

class TPNEmailChannel extends TPNBaseChannel implements TPNChannelInterface
{
    public function getType(): string
    {
        return 'email';
    }

    public function getMethod(): string
    {
        return 'toTPNEmail';
    }

    public function getRouteMethod(): string
    {
        return 'routeNotificationForTPNEmail';
    }

    public function transformMessageToArray($notification, $message): array
    {
        if (is_array($message)) {
            return $this->addCustomSMTPParameters($notification, $message);
        }

        if (! $message instanceof MailMessage && ! $message instanceof Mailable) {
            throw new Exception('Cannot send email notification because the method returns neither an array nor a MailMessage instance.');
        }

        if ( $message instanceof Mailable ) {
            $message->build();
        }

        $replyTo = $message->replyTo[0] ?? null;

        $plain = null;
        if (is_array($message->view) && $message->view[1]) {
            $plain = view($message->view[1], $message->data())->render();
        }

        $to = null;
        if ( $message instanceof Mailable ) {
            $to = collect($message->to)->map(fn($to) => $to['address'])->join(',');
        }

        return $this->addCustomSMTPParameters($notification, [
            'to' => $to,
            'cc' => implode(',', $message->cc ?? []) ?? null,
            'bcc' => implode(',', $message->bcc ?? []) ?? null,
            'from' => $message->from[0] ?? config('mail.from.address'),
            'from_name' => $message->from[1] ?? config('mail.from.name'),
            'reply_to' => $this->getReplyTo($replyTo),
            'reply_to_name' => $this->getReplyToName($replyTo),
            'subject' => $message->subject,
            'html' => (string) $message->render(),
            'plain' => $plain,
            'headers' => method_exists($notification, 'getHeaders') ? $notification->getHeaders() : null,
        ]);
    }

    public function getReplyTo(array $replyTo = null): ?string
    {
        if ( ! $replyTo ) {
            return null;
        }

        if ( isset($replyTo['address']) ) {
            return $replyTo['address'];
        }

        return $replyTo[0] ?? null;
    }

    public function getReplyToName(array $replyTo = null): ?string
    {
        if ( ! $replyTo ) {
            return null;
        }

        if ( isset($replyTo['name']) ) {
            return $replyTo['name'];
        }

        return $replyTo[0] ?? null;
    }

    public function addCustomSMTPParameters($notification, $message): array
    {
        if (! method_exists($notification, 'getCustomSMTPParameters')) {
            return $message;
        }

        $smtp = $notification->getCustomSMTPParameters();

        return $smtp
            ? array_merge($message, [
                'custom_smtp' => $smtp,
                'from' => $smtp['username'],
            ])
            : $message;
    }
}
