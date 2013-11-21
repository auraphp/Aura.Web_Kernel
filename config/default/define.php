<?php
/**
 * Services
 */
$di->set('web_request', $di->lazyNew('Aura\Web\Request'));
$di->set('web_response', $di->lazyNew('Aura\Web\Response'));
$di->set('web_router', $di->lazyNew('Aura\Router\Router'));
$di->set('web_dispatcher', $di->lazyNew('Aura\Dispatcher\Dispatcher'));
