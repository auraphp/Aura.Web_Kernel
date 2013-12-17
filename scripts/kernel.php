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

// get the project kernel
$base = dirname(dirname(dirname(dirname(__DIR__))));
$project_kernel = require "{$base}/vendor/aura/project-kernel/scripts/kernel.php";

// invoke it to get the DI container
$di = $project_kernel->__invoke();

// create a web kernel instance from the DI container and invoke it
$web_kernel = $di->newInstance('Aura\Web_Kernel\WebKernel');
$web_kernel->__invoke();
