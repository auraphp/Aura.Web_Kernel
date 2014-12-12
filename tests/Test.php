<?php

namespace Tarcha\WebKernel\Tests;

use Aura\Di\ContainerBuilder;
use Aura\Project_Kernel\Factory;
use Aura\Web\FakeResponseSender;

abstract class Test extends \PHPUnit_Framework_TestCase
{
    public function newContainer()
    {
        $path = dirname(__DIR__);
        $container = (new Factory)->newContainer(
            $path,
            '',
            $path . '/composer.json',
            $path . '/vendor/composer/installed.json'
        );
        return $container;
    }
}
