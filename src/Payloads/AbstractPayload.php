<?php

namespace Tarcha\WebKernel\Payloads;

abstract class AbstractPayload implements PayloadInterface
{
    public $payload = [];

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function get($key = null)
    {
        if ($key === null) {
            return $this->payload;
        }

        if (isset($this->payload[$key])) {
            return $this->payload[$key];
        }

        return null;
    }
}
