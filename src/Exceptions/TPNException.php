<?php

namespace Deegitalbe\LaravelTrustUpIoNotifier\Exceptions;

use Exception;

class TPNException extends Exception
{

    public $response = null;

    public static function failed(string $type, $response): self
    {
        $exception = new self('Could not send notification ['.$type.'] via TrustUp Notifier.');
        $exception->response = $response;
        return throw $exception;
    }

    public function context(): array
    {
        return ['response' => $this->response, 'body' => $this->response?->json(), 'url' => config('trustup-io-notifier.url')];
    }

}