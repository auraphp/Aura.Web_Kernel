<?php

namespace Tarcha\WebKernel\Tests\Filters;

use Tarcha\WebKernel\Tests\Test;
use Tarcha\WebKernel\Filters\AbstractFilter;

class AbstractFilterTest extends Test
{
    public function setUp()
    {
        $container  = $this->newContainer();
        $this->filter = $container->newInstance('Tarcha\WebKernel\Filters\AbstractFilter');
    }
    
    public function testId()
    {
        $id = 123;
        $this->filter->addId('id');
        $val = $this->filter->validate(['id' => $id]);
        $this->assertTrue($val);
    }
    
    public function testIdNotInt()
    {
        $id = 'sdfgh';
        $this->filter->addId('id');
        $val = $this->filter->validate(['id' => $id]);
        $this->assertFalse($val);
    }
    
    public function testIdZero()
    {
        $id = 0;
        $this->filter->addId('id');
        $val = $this->filter->validate(['id' => $id]);
        $this->assertFalse($val);
    }
    
    public function testString()
    {
        $name = 'asdfgt';
        $this->filter->addString('name');
        $val = $this->filter->validate(['name' => $name]);
        $this->assertTrue($val);
    }
    
    public function testStringNotValid()
    {
        $name = 1234;
        $this->filter->addString('name');
        $val = $this->filter->validate(['name' => $name]);
        $this->assertFalse($val);
    }
    
    public function testInt()
    {
        $num = 1234;
        $this->filter->addInt('number');
        $val = $this->filter->validate(['number' => $num]);
        $this->assertTrue($val);
    }
    
    public function testIntNotValid()
    {
        $num = '123.322';
        $this->filter->addInt('number');
        $val = $this->filter->validate(['number' => $num]);
        $this->assertFalse($val);
    }
    
    public function testTime()
    {
        $time = 123443212121212445;
        $this->filter->addTime('time');
        $val = $this->filter->validate(['time' => $time]);
        $this->assertTrue($val);
    }
    
    public function testTimeNotValid()
    {
        $time = '123dsas';
        $this->filter->addTime('time');
        $val = $this->filter->validate(['time' => $time]);
        $this->assertFalse($val);
    }
    
    public function testTimeZero()
    {
        $time = 0;
        $this->filter->addTime('time');
        $val = $this->filter->validate(['time' => $time]);
        $this->assertFalse($val);
    }
    
    public function testFloat()
    {
        $f = 12344321.432;
        $this->filter->addFloat('f');
        $val = $this->filter->validate(['f' => $f]);
        $this->assertTrue($val);
    }
    
    public function testFloatNotValid()
    {
        $f = '123dsas';
        $this->filter->addFloat('f');
        $val = $this->filter->validate(['f' => $f]);
        $this->assertFalse($val);
    }
}