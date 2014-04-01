<?php
error_reporting(E_ALL);

$composer_autoload = __DIR__ . "/integration/vendor/autoload.php";
if (! is_readable($composer_autoload)) {
    echo "Did not find 'integration/vendor/autoload.php'." . PHP_EOL;
    echo "Try ./integration.sh instead of phpunit." . PHP_EOL;
    exit(1);
}

require $composer_autoload;
require dirname(__DIR__) . '/autoload.php';
