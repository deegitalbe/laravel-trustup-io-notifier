<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

use Exception;
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

    public function transformMessageToArray($message): array
    {
        if ( is_array($message) ) {
            return $message;
        }

        if ( ! $message instanceof MailMessage ) {
            throw new Exception('Cannot send email notification because the method returns neither an array nor a MailMessage instance.');
        }

        $replyTo = $message->replyTo[0] ?? null;
        
        $plain = null;
        if ( is_array($message->view) && $message->view[1] ) {
            $plain = view($message->view[1], $message->data())->render();
        }
        
        return [
            'cc' => implode(',', $message->cc ?? []) ?? null,
            'bcc' => implode(',', $message->bcc ?? []) ?? null,
            'from_to' => $message->from[0],
            'from_to_name' => $message->from[1] ?? null,
            'reply_to' => $replyTo ? $replyTo[0] : null,
            'reply_to_name' => $replyTo ? $replyTo[1] : null,
            'subject' => $message->subject,
            'html' => (string) $message->render(),
            'plain' => $plain
        ];
    }
}
