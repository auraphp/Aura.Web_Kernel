<?php
namespace Aura\Web_Kernel\_Config;

use Aura\Di\Config;
use Aura\Di\Container;

class Common extends Config
{
    public function define(Container $di)
    {
        // services
        $di->set('aura/web-kernel:request', $di->lazyNew('Aura\Web\Request'));
        $di->set('aura/web-kernel:response', $di->lazyNew('Aura\Web\Response'));
        $di->set('aura/web-kernel:response_sender', $di->lazyNew('Aura\Web\ResponseSender'));
        $di->set('aura/web-kernel:router', $di->lazyNew('Aura\Router\Router'));
        $di->set('aura/web-kernel:dispatcher', $di->lazyNew('Aura\Dispatcher\Dispatcher'));

        // Aura\Web\ResponseSender
        $di->params['Aura\Web\ResponseSender'] = array(
            'response' => $di->lazyGet('web_response'),
        );

        // Aura\Web_Kernel\AbstractAction
        $di->params['Aura\Web_Kernel\AbstractAction'] = array(
            'request' => $di->lazyGet('web_request'),
            'response' => $di->lazyGet('web_response'),
        );

        // Aura\Web_Kernel\WebKernel
        $di->params['Aura\Web_Kernel\WebKernel'] = array(
            'router' => $di->lazyNew('Aura\Web_Kernel\WebKernelRouter'),
            'dispatcher' => $di->lazyNew('Aura\Web_Kernel\WebKernelDispatcher'),
            'response_sender' => $di->lazyNew('Aura\Web\ResponseSender'),
        );

        // Aura\Web_Kernel\WebKernelDispatcher
        $di->params['Aura\Web_Kernel\WebKernelDispatcher'] = array(
            'request' => $di->lazyGet('web_request'),
            'dispatcher' => $di->lazyGet('web_dispatcher'),
            'logger' => $di->lazyGet('logger'),
        );

        // Aura\Web_Kernel\WebKernelRouter
        $di->params['Aura\Web_Kernel\WebKernelRouter'] = array(
            'request' => $di->lazyGet('web_request'),
            'router' => $di->lazyGet('web_router'),
            'logger' => $di->lazyGet('logger'),
        );

    }

    public function modify(Container $di)
    {
        $dispatcher = $di->get('aura/web-kernel:dispatcher');
        $request = $di->get('aura/web-kernel:request');
        $response = $di->get('aura/web-kernel:response');

        // use 'action' from the route params
        $dispatcher->setObjectParam('action');

        // for when the url has no matching route
        $dispatcher->setObject(
            'aura.web_kernel.missing_route',
            $di->lazyNew('Aura\Web_Kernel\MissingRoute')
        );

        // for when the controller was not found
        $dispatcher->setObject(
            'aura.web_kernel.missing_action',
            $di->lazyNew('Aura\Web_Kernel\MissingAction')
        );

        // for when the kernel has caught an exception
        $dispatcher->setObject(
            'aura.web_kernel.caught_exception',
            $di->lazyNew('Aura\Web_Kernel\CaughtException')
        );
    }
}
