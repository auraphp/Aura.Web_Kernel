<?php
/**
 * @var $di Aura\Di\Container The DI container.
 */
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
