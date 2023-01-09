<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels;

use Exception;
use Illuminate\Notifications\Messages\SlackMessage;

class TPNSlackChannel extends TPNBaseChannel implements TPNChannelInterface
{
    public function getType(): string
    {
        return 'slack';
    }

    public function getMethod(): string
    {
        return 'toTPNslack';
    }

    public function getRouteMethod(): string
    {
        return 'routeNotificationForTPNSlack';
    }

    public function transformMessageToArray($notification, $message): array
    {
        if ( is_array($message) ) {
            return $message;
        }

        if ( ! $message instanceof SlackMessage ) {
            throw new Exception('Cannot send Slack notification because the method returns neither an array nor a SlackMessage instance.');
        }

        return [
            'to' => $message->channel,
            'content' => $message->content,
            'attachments' => $this->getMessageAttachments($message)
        ];
    }

    public function getMessageAttachments(SlackMessage $message): ?array
    {
        if ( empty($message->attachments) ) {
            return null;
        }

        return collect($message->attachments)->map(function($attachment) {
            return [
                'title' => $attachment->title,
                'title_link' => $attachment->url,
                'author' => $attachment->authorName,
                'author_link' => $attachment->authorLink,
                'author_icon' => $attachment->authorIcon,
                'pretext' => $attachment->pretext,
                'content' => $attachment->content,
                'color' => $attachment->color,
                'fields' => $attachment->fields,
                'image' => $attachment->imageUrl,
                'footer' => $attachment->footer,
                'footer_icon' => $attachment->footerIcon,
            ];
        })->toArray();
    }

}
