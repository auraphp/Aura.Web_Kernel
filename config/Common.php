<?php
namespace Aura\Web_Kernel\_Config;

use Aura\Di\Config;
use Aura\Di\Container;

class Common extends Config
{
    public function define(Container $di)
    {
        // services
        $di->set('web_request', $di->lazyNew('Aura\Web\Request'));
        $di->set('web_response', $di->lazyNew('Aura\Web\Response'));
        $di->set('web_response_sender', $di->lazyNew('Aura\Web\ResponseSender'));
        $di->set('web_router', $di->lazyNew('Aura\Router\Router'));
        $di->set('web_dispatcher', $di->lazyNew('Aura\Dispatcher\Dispatcher'));

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
            'logger' => $di->lazyGet('aura/project-kernel:logger'),
        );

        // Aura\Web_Kernel\WebKernelRouter
        $di->params['Aura\Web_Kernel\WebKernelRouter'] = array(
            'request' => $di->lazyGet('web_request'),
            'router' => $di->lazyGet('web_router'),
            'logger' => $di->lazyGet('aura/project-kernel:logger'),
        );

    }

    public function modify(Container $di)
    {
        $dispatcher = $di->get('web_dispatcher');
        $request = $di->get('web_request');
        $response = $di->get('web_response');

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
