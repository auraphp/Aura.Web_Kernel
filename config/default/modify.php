<?php
/**
 * @var $di Aura\Di\Container The DI container.
 */
$dispatcher = $di->get('web_dispatcher');
$request = $di->get('web_request');
$response = $di->get('web_response');

$dispatcher->setObjectParam('controller');
$dispatcher->setMethodParam('action');

// the url has no matching route
$dispatcher->setObject(
    'aura.web_kernel.missing_route',
    function () use ($request, $response) {
        $content = 'No route for '
                 . $request->method->get() . ' '
                 . $request->url->get(PHP_URL_PATH)
                 . PHP_EOL;
        $response->status->set('404', 'Not Found');
        $response->content->set($content);
        $response->content->setType('text/plain');
    }
);

// the controller by the route was not found
$dispatcher->setObject(
    'aura.web_kernel.missing_controller',
    function ($missing_controller) use ($request, $response) {
        $content = "Missing controller '$missing_controller'  for "
                 . $request->method->get() . ' '
                 . $request->url->get(PHP_URL_PATH) . PHP_EOL . PHP_EOL
                 . 'Params: ' . var_export($request->params->get(), true)
                 . PHP_EOL;
        $response->status->set('404', 'Not Found');
        $response->content->set($content);
        $response->content->setType('text/plain');
    }
);

// the kernel caught an exception
$dispatcher->setObject(
    'aura.web_kernel.caught_exception',
    function ($exception) use ($request, $response) {
        $content = "Exception '" . get_class($exception) . "' thrown for "
                 . $request->method->get() . ' '
                 . $request->url->get(PHP_URL_PATH) . PHP_EOL . PHP_EOL
                 . 'Params: ' . var_export($request->params->get(), true)
                 . PHP_EOL . PHP_EOL
                 . (string) $exception
                 . PHP_EOL;
        $response->status->set('500', 'Server Error');
        $response->content->set($content);
        $response->content->setType('text/plain');
    }
);
