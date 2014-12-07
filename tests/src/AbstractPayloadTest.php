<?php
namespace Tarcha\WebKernel\Tests;

class AbstractPayloadTest extends \PHPUnit_Framework_TestCase
{
    public function getPayload($args = [])
    {
        return $this->getMockForAbstractClass(
            'Tarcha\WebKernel\Payloads\AbstractPayload',
            func_get_args()
        );
    }

    public function testGetPartialBasedOnKey()
    {
        $p = $this->getPayload(['data' => 'foo']);

        $this->assertEquals($p->get('data'), 'foo');
    }

    public function testGetAll()
    {
        $p = $this->getPayload(['data' => 'foo']);

        $this->assertEquals($p->get(), ['data' => 'foo']);
    }

    public function testInvalid()
    {
        $p = $this->getPayload(['data' => 'foo']);
        $this->assertNull($p->get('foobar'));
    }
}
