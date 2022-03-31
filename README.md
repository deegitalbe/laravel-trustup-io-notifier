
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Trustup Pro Notifier

[![Latest Version on Packagist](https://img.shields.io/packagist/v/deegitalbe/trustup-pro-notifier.svg?style=flat-square)](https://packagist.org/packages/deegitalbe/trustup-pro-notifier)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/deegitalbe/trustup-pro-notifier/run-tests?label=tests)](https://github.com/deegitalbe/trustup-pro-notifier/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/deegitalbe/trustup-pro-notifier/Check%20&%20fix%20styling?label=code%20style)](https://github.com/deegitalbe/trustup-pro-notifier/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/deegitalbe/trustup-pro-notifier.svg?style=flat-square)](https://packagist.org/packages/deegitalbe/trustup-pro-notifier)

Easily send notifications through a centralized notifier instance. Supports emails (Postmak), sms (Vonage/Nexmo), postal letters (Postbird) and push (FCM) via custom notification channels that are easy to use. A single app name and token are enough to use all these channels.

## Installation

You can install the package via composer:

```bash
composer require deegitalbe/trustup-pro-notifier
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="trustup-pro-notifier-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="trustup-pro-notifier-config"
```

This is the contents of the published config file:

```php
return [

    /**
     * Sets at which URL the notifier is accessible.
     * Default value: https://notifier.trustup.pro
     */
    'url' => env('TPN_URL', 'https://notifier.trustup.pro'),

    /**
     * App name (default, invoicing...).
     */
    'app' => env('TPN_APP_NAME', 'default'),

    /**
     * App key
     */
    'key' => env('TPN_APP_KEY')
];
```

## Usage

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $channels;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['tpn_sms', 'tpn_email', 'tpn_letter', 'tpn_push', 'database'];
    }
    
    public function toTPNSMS($notifiable): array
    {
        return [
            'to' => '31657616867',
            'text' => 'This is a test SMS'
        ];
    }
    
    public function toTPNEmail($notifiable): array
    {
        return [
            'to' => 'florian.husquinet@deegital.be',
            'html' => '<h1>Demo notification</h1><p>This is my email content...</p>',
            'plain' => 'This is my email content...',
            'subject' => 'Demo notification',
            'headers' => [
                'X-Model-ID' => 1,
                'X-Model-Type' => 'user'
            ]
        ];
    }
    
    public function toTPNPush($notifiable): array
    {
        return [
            'to' => 'f0TAY_cMSpi2nNnakQ_B0w:APA91bFV1-2sblQS1h9mGn6I_aYJEZtww67fCJXN3Ir7V1179q7z_oHDLipQL1KAFs7meUyveVomzi2wLHTYuzXR7rDDnFiOBmCzGFEx-_aRszH0B2lIIelqzBjEjo5cL2t98bZc3B5g',
            'name' => 'demo-notification',
            'title' => 'Demo notification',
            'body' => 'Lorem ipsum...',
            'data' => [
                'type' => 'new-request',
                'id' => '555'
            ]
        ];
    }
    
    public function toTPNLetter($notifiable): array
    {
        return [
            'name' => 'demo-notification',
            'pdf' => 'https://trustup-dev-billing.ams3.digitaloceanspaces.com/202202-2263%20(5).pdf'
        ];
    }
    
    public function toArray($notifiable)
    {
        return [
            'channels' => $this->via($notifiable),
            'to' => '31657616867',
            'text' => 'This is a demo notification'
        ];
    }
}
```

## What happens when you send a notification
The channel will make the API call to the notifier instance for each channel provided with a uuid that is generated then stored in the `notification_log_uuids`. You can then see how your notification behaved once it was send to the notifier by querying it using that uuid.  
Notifications should be sent in queue from your app, as this is always the best possible use. Regardless of what you do in your own app, the notifier will accept the notification and send it to its own queue. There might be a delay of a few seconds before it is handled.