<?php
error_reporting(E_ALL);

$rootDir = dirname(__DIR__);
$composer_autoload = $rootDir . "/vendor/autoload.php";
if (! is_readable($composer_autoload)) {
    echo "Did not find 'vendor/autoload.php'." . PHP_EOL;
    echo "Try ./phpunit.sh instead of phpunit." . PHP_EOL;
    exit(1);
}

require $composer_autoload;

// need the fake response sender from the Aura.Web tests
require $rootDir . "/vendor/aura/web/tests/unit/src/FakeResponseSender.php";
