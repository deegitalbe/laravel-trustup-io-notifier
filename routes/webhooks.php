<?php

use Deegitalbe\TrustupProNotifier\Controllers\WebhookController;

Route::prefix('webhooks/tpn')->group(function() {
    Route::post('new-event', [WebhookController::class, 'handle']);
});