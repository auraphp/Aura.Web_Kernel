<?php

namespace Tarcha\WebKernel\Payloads;

use Aura\Di\Container;


class Factory
{
    public function __construct(Container $di)
    {
        $this->di = $di;
    }

    public function noContent(array $data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\NoContent', $data);
    }

    public function success(array $data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\Success', $data);
    }

    public function error(array $data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\Error', $data);
    }

    public function notFound(array $data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\NotFound', $data);
    }

    public function notRecognized(array $data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\NotRecognized', $data);
    }

    public function created(array $data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\Created', $data);
    }

    public function alreadyExists(array $data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\AlreadyExists', $data);
    }
}
