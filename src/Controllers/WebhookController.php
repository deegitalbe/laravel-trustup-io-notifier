<?php

namespace Deegitalbe\TrustupProNotifier\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Deegitalbe\TrustupProNotifier\Jobs\HandleNewEventWebhook;

class WebhookController extends Controller
{

    public function handle(Request $request)
    {
        HandleNewEventWebhook::dispatch($request->all());
    }

}