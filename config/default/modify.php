<?php
$dispatcher = $di->get('web_dispatcher');

$dispatcher->setObjectParam('controller');
$dispatcher->setMethodParam('action');

$dispatcher->setObject('no_route', function ($request, $response) {
    $response->status->set('404', 'Not Found');
    $response->content->set(
        'No route for '
        . $request->method->get() . ' '
        . $request->url->get(PHP_URL_PATH)
        . PHP_EOL
    );
});

$dispatcher->setObject('no_controller', function ($request, $response) {
    $response->status->set('404', 'Not Found');
    $response->content->set(
        'No controller for '
        . $request->method->get() . ' '
        . $request->url->get(PHP_URL_PATH) . PHP_EOL . PHP_EOL
        . 'Params: ' . var_export($request->params->get(), true)
        . PHP_EOL
    );
});
