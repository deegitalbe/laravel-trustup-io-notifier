<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Notifications\Channels;

interface TPNChannelInterface
{
    public function getType(): string;

    public function getMethod(): string;

    public function getRouteMethod(): string;
}
