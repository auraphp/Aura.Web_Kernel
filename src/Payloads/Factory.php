<?php

namespace Tarcha\WebKernel\Payloads;

use Aura\Di\Container;


class Factory
{
    public function __construct(Container $di)
    {
        $this->di = $di;
    }

    public function noContent($data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\NoContent', $data);
    }

    public function success($data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\Success', $data);
    }

    public function error($data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\Error', $data);
    }

    public function notFound($data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\NotFound', $data);
    }

    public function notRecognized($data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\NotRecognized', $data);
    }

    public function created($data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\Created', $data);
    }

    public function alreadyExists($data)
    {
        return $di->newInstance('Tarcha\WebKernel\Paylaods\AlreadyExists', $data);
    }
}
