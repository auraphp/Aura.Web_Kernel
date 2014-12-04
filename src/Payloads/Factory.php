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
        return $this->di->newInstance('Tarcha\WebKernel\Payloads\NoContent', [$data]);
    }

    public function success($data)
    {
        return $this->di->newInstance('Tarcha\WebKernel\Payloads\Success', [$data]);
    }

    public function error($data)
    {
        return $this->di->newInstance('Tarcha\WebKernel\Payloads\Error', [$data]);
    }

    public function dbError($data)
    {
        return $this->di->newInstance('Tarcha\WebKernel\Payloads\DbError', [$data]);
    }

    public function notFound($data)
    {
        return $this->di->newInstance('Tarcha\WebKernel\Payloads\NotFound', [$data]);
    }

    public function notRecognized($data)
    {
        return $this->di->newInstance('Tarcha\WebKernel\Payloads\NotRecognized', [$data]);
    }

    public function created($data)
    {
        return $this->di->newInstance('Tarcha\WebKernel\Payloads\Created', [$data]);
    }

    public function alreadyExists($data)
    {
        return $this->di->newInstance('Tarcha\WebKernel\Payloads\AlreadyExists', [$data]);
    }
}
