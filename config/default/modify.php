<?php
$dispatcher = $di->get('web_dispatcher');
$request = $di->get('web_request');
$response = $di->get('web_response');

$dispatcher->setObjectParam('controller');
$dispatcher->setMethodParam('action');

$dispatcher->setObject('no_route', function () use ($request, $response) {
    $response->status->set('404', 'Not Found');
    $response->content->set(
        'No route for '
        . $request->method->get() . ' '
        . $request->url->get(PHP_URL_PATH)
        . PHP_EOL
    );
});

$dispatcher->setObject('no_controller', function () use ($request, $response) {
    $response->status->set('404', 'Not Found');
    $response->content->set(
        'No controller for '
        . $request->method->get() . ' '
        . $request->url->get(PHP_URL_PATH) . PHP_EOL . PHP_EOL
        . 'Params: ' . var_export($request->params->get(), true)
        . PHP_EOL
    );
});
