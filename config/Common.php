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
        $di->set('aura/web-kernel:router', $di->lazyNew('Aura\Router\Router'));
        $di->set('aura/web-kernel:dispatcher', $di->lazyNew('Aura\Dispatcher\Dispatcher'));

        // Aura\Web\ResponseSender
        $di->params['Aura\Web\ResponseSender'] = array(
            'response' => $di->lazyGet('aura/web-kernel:response'),
        );

        // Aura\Web_Kernel\Abstract_Responder
        $di->params['Aura\Web_Kernel\AbstractResponder'] = array(
            'response' => $di->lazyGet('aura/web-kernel:response'),
        );

        // Aura\Web_Kernel\CaughtException
        $di->params['Aura\Web_Kernel\CaughtException'] = array(
            'request' => $di->lazyGet('aura/web-kernel:request'),
            'responder' => $di->lazyNew('Aura\Web_Kernel\CaughtExceptionResponder'),
        );

        // Aura\Web_Kernel\MissingAction
        $di->params['Aura\Web_Kernel\MissingAction'] = array(
            'request' => $di->lazyGet('aura/web-kernel:request'),
            'responder' => $di->lazyNew('Aura\Web_Kernel\MissingActionResponder'),
        );

        // Aura\Web_Kernel\MissingRoute
        $di->params['Aura\Web_Kernel\MissingRoute'] = array(
            'request' => $di->lazyGet('aura/web-kernel:request'),
            'responder' => $di->lazyNew('Aura\Web_Kernel\MissingRouteResponder'),
        );

        // Aura\Web_Kernel\WebKernel
        $di->params['Aura\Web_Kernel\WebKernel'] = array(
            'router' => $di->lazyNew('Aura\Web_Kernel\WebKernelRouter'),
            'dispatcher' => $di->lazyNew('Aura\Web_Kernel\WebKernelDispatcher'),
            'response_sender' => $di->lazyNew('Aura\Web\ResponseSender'),
        );

        // Aura\Web_Kernel\WebKernelDispatcher
        $di->params['Aura\Web_Kernel\WebKernelDispatcher'] = array(
            'request' => $di->lazyGet('aura/web-kernel:request'),
            'dispatcher' => $di->lazyGet('aura/web-kernel:dispatcher'),
            'logger' => $di->lazyGet('aura/project-kernel:logger'),
        );

        // Aura\Web_Kernel\WebKernelRouter
        $di->params['Aura\Web_Kernel\WebKernelRouter'] = array(
            'request' => $di->lazyGet('aura/web-kernel:request'),
            'router' => $di->lazyGet('aura/web-kernel:router'),
            'logger' => $di->lazyGet('aura/project-kernel:logger'),
        );

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
