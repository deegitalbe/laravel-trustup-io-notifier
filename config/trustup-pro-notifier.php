<?php

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
    'key' => env('TPN_APP_KEY'),

    'webhooks' => [
        'new-event' => [
            
            /**
             * If you do not want to use this event, please disable this option.
             * The event class won't handle the data and it will simply be ignored.
             * Note that traffic will still hit your app, which might not be wanted.
             * The notifier app should be changed to simply not trigger this webhook at all if there is no need for it...
             */
            'enabled' => false,

            /**
             * Listener for the NewEventWebhookReceived event.
             * This event will be sent when the notifier receives a new webhook from an external driver based on a user action (email opened, link clicked...).
             * The notifier will then send a webhook to the app using this package with the uuids of the related models + the data.
             * Please note that the default listener does nothing, while the webhook is still processed. Either change this value or disable it.
             */
            'listener' => \Deegitalbe\TrustupProNotifier\Listeners\LogNewEvent::class
        ]
    ]
];