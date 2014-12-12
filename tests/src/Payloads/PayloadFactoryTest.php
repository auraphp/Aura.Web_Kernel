<?php

namespace Tarcha\WebKernel\Tests\Payloads;

use Tarcha\WebKernel\Tests\Test;

class PayloadFactoryTest extends Test
{
    protected $ns = 'Tarcha\WebKernel\Payloads';

    public function assertPayload($payload)
    {
        static $container;
        $ns = 'Tarcha\WebKernel\Payloads\\';

        if (empty($container)) {
            $container = $this->newContainer();
        }

        $this->assertInstanceOf(
            $ns . $payload,
            $container->newInstance($ns . $payload)
        );
    }

    public function testAlreadyExists()
    {
        $this->assertPayload('AlreadyExists');
    }

    public function testCreated()
    {
        $this->assertPayload('Created');
    }

    public function testDbError()
    {
        $this->assertPayload('DbError');
    }

    public function testError()
    {
        $this->assertPayload('Error');
    }

    public function testInvalid()
    {
        $this->assertPayload('Invalid');
    }

    public function testNoContent()
    {
        $this->assertPayload('NoContent');
    }

    public function testNotFound()
    {
        $this->assertPayload('NotFound');
    }

    public function testNotRecognized()
    {
        $this->assertPayload('NotRecognized');
    }

    public function testSuccess()
    {
        $this->assertPayload('Success');
    }
}
