<?php
// turn on all errors
error_reporting(E_ALL);

// look for a composer autoloader relative to
// {$base}/vendor/aura/web-kernel/tests/bootstrap.php
$base = dirname(dirname(dirname(dirname(__DIR__))));
$file = "{$base}/vendor/autoload.php";
if (! is_readable($file)) {
    $_ENV['AURA_TESTING_BASE_DIR'] = $base = dirname(__DIR__);
    $file1 = "{$base}/vendor/autoload.php";
    if (! is_readable($file1)) {
        echo "Did not find '{$file}' or '{$file1}'." . PHP_EOL;
        echo "It looks like you are not in a Composer installation." . PHP_EOL;
        exit(1);
    }
    require "{$base}/autoload.php";
    $file = $file1;
}
// include the composer autoloader
require $file;
