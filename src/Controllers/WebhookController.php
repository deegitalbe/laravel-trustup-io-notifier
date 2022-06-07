<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Controllers;

use Deegitalbe\LaravelTrustUpIoNotifier\Jobs\HandleNewEventWebhook;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        HandleNewEventWebhook::dispatch($request->all());
    }
}
