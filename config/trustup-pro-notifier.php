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
    'key' => env('TPN_APP_KEY')
];