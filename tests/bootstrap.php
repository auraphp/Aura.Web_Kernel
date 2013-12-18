<?php
// turn on all errors
error_reporting(E_ALL);

// look for a composer autoloader relative to
// {$base}/vendor/aura/web-kernel/tests/bootstrap.php
$base = dirname(dirname(dirname(dirname(__DIR__))));
$file = "{$base}/vendor/autoload.php";
if (! is_readable($file)) {
    echo "Did not find '{$file}'." . PHP_EOL;
    echo "It looks like you are not in a Composer installation." . PHP_EOL;
    exit(1);
}

// include the composer autoloader
require $file;
