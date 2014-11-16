<?php
namespace Tarcha\WebKernel\_Config;

use Tarcha\WebKernel\_Config\Common;
use Aura\Di\Config;
use Aura\Di\Container;

class WebKernelTest extends Common
{
    public function define(Container $di)
    {
        parent::define($di);

        $di->params['Aura\Web\FakeResponseSender']['response']
            = $di->lazyGet('aura/web-kernel:response');

        $di->params['Tarcha\WebKernel\WebKernel']['response_sender']
            = $di->lazyNew('Aura\Web\FakeResponseSender');
    }

    public function modify(Container $di)
    {
        parent::modify($di);

        $request = $di->get('aura/web-kernel:request');
        $response = $di->get('aura/web-kernel:response');
        $router = $di->get('aura/web-kernel:router');

        $router->add(null, '/aura/web-kernel/integration/hello')
            ->addValues(array(
                'action' => function () use ($request, $response) {
                    $response->headers->set('X-Hello', 'World');
                    $response->cookies->set('hello', 'world');
                    $response->content->set('Hello World!');
                },
            ));

        $router->add(null, '/aura/web-kernel/integration/missing-action')
            ->addValues(array(
                'action' => 'no-such-action',
            ));

        $router->add(null, '/aura/web-kernel/integration/throw-exception')
            ->addValues(array(
                'action' => function () {
                    throw new \Exception('Mock exception');
                },
            ));
    }
}
