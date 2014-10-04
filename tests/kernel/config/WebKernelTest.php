<?php
namespace Aura\Web_Kernel\_Config;

use Aura\Di\Config;
use Aura\Di\Container;

class WebKernelTest extends Config
{
    public function define(Container $di)
    {
        $di->params['Aura\Web_Kernel\WebKernel']['response_sender'] = $di->lazyNew(
            'Aura\Web\FakeResponseSender'
        );
    }

    public function modify(Container $di)
    {
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
