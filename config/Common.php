<?php
namespace Tarcha\WebKernel\_Config;

use Aura\Web_Kernel\_Config\Common as AuraConfig;
use Aura\Di\Config;
use Aura\Di\Container;

class Common extends AuraConfig
{
    public function define(Container $di)
    {
        parent::define($di);

        $di->types['Aura\Web\Request'] = $di->lazyGet('aura/web-kernel:request');
        $di->types['Aura\Web\Response'] = $di->lazyGet('aura/web-kernel:response');
        $di->types['Aura\Router\Router'] = $di->lazyGet('aura/web-kernel:router');
        $di->types['Aura\Dispatcher\Dispatcher'] = $di->lazyGet('aura/web-kernel:dispatcher');

        // Aura\Web_Kernel\WebKernelRouter
        $di->params['Tarcha\WebKernel\WebKernelRouter']['logger']
            = $di->lazyGet('aura/project-kernel:logger');

        // Aura\Web_Kernel\WebKernelDispatcher
        $di->params['Tarcha\WebKernel\WebKernelDispatcher']['logger']
            = $di->lazyGet('aura/project-kernel:logger');

    }

    public function modify(Container $di)
    {
        parent::modify($di);

    }
}
