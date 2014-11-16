<?php
namespace Tarcha\WebKernel\_Config;

use Aura\Di\Config;
use Aura\Di\Container;

class Common extends Config
{
    public function define(Container $di)
    {
        // services
        $di->set('aura/web-kernel:request', $di->lazyNew('Aura\Web\Request'));
        $di->set('aura/web-kernel:response', $di->lazyNew('Aura\Web\Response'));
        $di->set('aura/web-kernel:router', $di->lazyNew('Aura\Router\Router'));
        $di->set('aura/web-kernel:dispatcher', $di->lazyNew('Aura\Dispatcher\Dispatcher'));

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
        $dispatcher = $di->get('aura/web-kernel:dispatcher');
        $request = $di->get('aura/web-kernel:request');
        $response = $di->get('aura/web-kernel:response');

        // use 'action' from the route params
        $dispatcher->setObjectParam('action');

        // the url has no matching route
        $dispatcher->setObject(
            'aura.web_kernel.missing_route',
            $di->lazyNew('Aura\Web_Kernel\MissingRoute')
        );

        // the action was not found
        $dispatcher->setObject(
            'aura.web_kernel.missing_action',
            $di->lazyNew('Aura\Web_Kernel\MissingAction')
        );

        // the kernel caught an exception
        $dispatcher->setObject(
            'aura.web_kernel.caught_exception',
            $di->lazyNew('Aura\Web_Kernel\CaughtException')
        );
    }
}
