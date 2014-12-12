<?php

namespace Tarcha\WebKernel\Tests\Entities;

use Tarcha\WebKernel\Tests\Test;

class AbstractEntityTest extends Test
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

    public function testSetData()
    {
        $e = $this->getPayload(['data' => 'foo']);

        $e->setData(['data' => 'bar']);
        $this->assertEquals($e->data, 'bar');
    }

    public function testIsDirtyOnNewData()
    {
        $e = $this->getPayload(['data' => 'foo']);

        $e->setData(['data' => 'bar']);
        $this->assertTrue($e->isDirty());
    }

    public function testIsNotDirtyOnNoNewData()
    {
        $e = $this->getPayload(['data' => 'foo']);

        $e->setData(['data' => 'foo']);
        $this->assertFalse($e->isDirty());
    }

    public function testGetData()
    {
        $e = $this->getPayload(['data' => 'foo']);

        $this->assertEquals($e->getData(), ['data' => 'foo']);
    }

    public function testSetOnlyPredefinedVariables()
    {
        $e = $this->getPayload(['data' => 'foo', 'bar' => 'baz']);

        $this->assertEquals($e->getData(), ['data' => 'foo']);
    }

    public function testJsonSerialize()
    {
        $e = $this->getPayload(['data' => 'foo']);

        $this->assertEquals(json_encode($e), json_encode(['data' => 'foo']));
    }
}
