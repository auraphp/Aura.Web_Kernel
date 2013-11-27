<?php
/**
 * 
 * This file is part of Aura for PHP. It is a bootstrap for Composer-oriented
 * web projects.
 * 
 * @package Aura.Web_Kernel
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 */
namespace Aura\Web_Kernel;

// the project base directory, relative to
// {$project}/vendor/aura/web_kernel/scripts/kernel.php
$base = dirname(dirname(dirname(dirname(__DIR__))));

// the project config mode
$file = str_replace("/", DIRECTORY_SEPARATOR, "{$base}/config/_mode");
$mode = trim(file_get_contents($file));
if (! $mode) {
    $mode = "default";
}

// composer autoloader
$loader = require "{$base}/vendor/autoload.php";

// create and invoke the project kernel to start the project running
$factory = new WebKernelFactory;
$kernel = $factory->newInstance($base, $mode, $loader);
$kernel->__invoke();
