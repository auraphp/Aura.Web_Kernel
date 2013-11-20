<?php
namespace Aura\Web_Kernel;

use Aura\Di\Container;
use Aura\Di\Forge;
use Aura\Di\Config;

class WebKernelFactory
{
    public function newInstance($base, $mode)
    {
        $di = new Container(new Forge(new Config));
        return new WebKernel($di, $base, $mode);
    }
}
