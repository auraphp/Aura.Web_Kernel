<?php

namespace Tarcha\WebKernel\Payloads;

use Aura\Di\Container;

class Factory
{
    public function __construct(Container $di)
    {
        $this->di = $di;
    }

    public function Json()
    {
        return $di->newInstance('Demograph\Kernel\Paylaods\Json');
    }

    public function noContent()
    {
        return $di->newInstance('Demograph\Kernel\Paylaods\NoContent');
    }
}
