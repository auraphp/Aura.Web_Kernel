<?php
/**
 * Modify the DI container for integration testing.
 */
$request = $di->get('web_request');
$response = $di->get('web_response');
$router = $di->get('web_router');

// get logger service and disable
$logger = $di->get('logger');
$logger->pushHandler($di->newInstance('Monolog\Handler\NullHandler'));

$router->add(null, '/aura/web-kernel/integration/hello')
    ->addValues(array(
        'controller' => function () use ($request, $response) {
            $response->headers->set('X-Hello', 'World');
            $response->cookies->set('hello', 'world');
            $response->content->set('Hello World!');
        },
    ));

$router->add(null, '/aura/web-kernel/integration/missing-controller')
    ->addValues(array(
        'controller' => 'no-such-controller',
    ));

$router->add(null, '/aura/web-kernel/integration/throw-exception')
    ->addValues(array(
        'controller' => function () {
            throw new \Exception('Mock exception');
        },
    ));
