<?php

namespace Tarcha\WebKernel\Tests;

class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{
    public function getPayload($args)
    {
        return new MockAbstractEntity($args);
    }

    public function testShouldNotBeDirtyOnInstanciation()
    {
        $e = $this->getPayload(['data' => 'foo']);

        $this->assertEquals($e->data, 'foo');
        $this->assertFalse($e->isDirty());
    }
}
