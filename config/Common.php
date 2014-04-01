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
        $di->set('web_router', $di->lazyNew('Aura\Router\Router'));
        $di->set('web_dispatcher', $di->lazyNew('Aura\Dispatcher\Dispatcher'));

        // Aura\Web_Kernel\AbstractController
        $di->params['Aura\Web_Kernel\AbstractController'] = array(
            'request' => $di->lazyGet('web_request'),
            'response' => $di->lazyGet('web_response'),
        );

        // Aura\Web_Kernel\WebKernel
        $di->params['Aura\Web_Kernel\WebKernel'] = array(
            'router' => $di->lazyNew('Aura\Web_Kernel\WebKernelRouter'),
            'dispatcher' => $di->lazyNew('Aura\Web_Kernel\WebKernelDispatcher'),
            'responder' => $di->lazyNew('Aura\Web_Kernel\WebKernelResponder'),
        );

        // Aura\Web_Kernel\WebKernelDispatcher
        $di->params['Aura\Web_Kernel\WebKernelDispatcher'] = array(
            'request' => $di->lazyGet('web_request'),
            'dispatcher' => $di->lazyGet('web_dispatcher'),
            'logger' => $di->lazyGet('logger'),
        );

        // Aura\Web_Kernel\WebKernelResponder
        $di->params['Aura\Web_Kernel\WebKernelResponder'] = array(
            'response' => $di->lazyGet('web_response'),
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
        $dispatcher = $di->get('web_dispatcher');
        $request = $di->get('web_request');
        $response = $di->get('web_response');

        // use 'controller' and 'action' from the route params
        $dispatcher->setObjectParam('controller');
        $dispatcher->setMethodParam('action');

        // for when the url has no matching route
        $dispatcher->setObject(
            'aura.web_kernel.missing_route',
            $di->lazyNew('Aura\Web_Kernel\MissingRoute')
        );

        // for when the controller was not found
        $dispatcher->setObject(
            'aura.web_kernel.missing_controller',
            $di->lazyNew('Aura\Web_Kernel\MissingController')
        );

        // for when the kernel has caught an exception
        $dispatcher->setObject(
            'aura.web_kernel.caught_exception',
            $di->lazyNew('Aura\Web_Kernel\CaughtException')
        );
    }
}
