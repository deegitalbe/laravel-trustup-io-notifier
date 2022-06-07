<?php

use Deegitalbe\LaravelTrustUpIoNotifier\Controllers\WebhookController;

Route::prefix('webhooks/tpn')->group(function() {
    Route::post('new-event', [WebhookController::class, 'handle']);
});