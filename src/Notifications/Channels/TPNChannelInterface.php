<?php

namespace Deegitalbe\TrustupProNotifier\Notifications\Channels;

interface TPNChannelInterface
{

    public function getType(): string;

    public function getMethod(): string;

    public function getRouteMethod(): string;

}