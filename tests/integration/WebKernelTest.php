<?php
namespace Aura\Web_Kernel;

class WebKernelTest extends \PHPUnit_Framework_TestCase
{
    protected $web_kernel;
    
    protected function exec()
    {
        // force into integration mode
        $_ENV['AURA_CONFIG_MODE'] = 'integration';
        
        // always have an HTTP_HOST or request uri won't get put together
        $_SERVER['HTTP_HOST'] = 'example.com';
        require dirname(dirname(__DIR__)) . '/scripts/kernel.php';
        
        // retain from the kernel script
        $this->web_kernel = $web_kernel;
    }
    
    public function testHelloWorld()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/aura/web-kernel/integration/hello';
        $this->exec();
        $expect = 'Hello World!';
        $actual = $this->web_kernel->responder->content;
        $this->assertSame($expect, $actual);
    }
    
    public function testHelloWorldViaIndexPhp()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/index.php/aura/web-kernel/integration/hello';
        $this->exec();
        $expect = 'Hello World!';
        $actual = $this->web_kernel->responder->content;
        $this->assertSame($expect, $actual);
    }
    
    public function testMissingRoute()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/aura/web-kernel/integration/missing-route';
        $this->exec();
        $expect = 'No route for GET /aura/web-kernel/integration/missing-route';
        $actual = trim($this->web_kernel->responder->content);
        $this->assertSame($expect, $actual);
    }
    
    public function testMissingContoller()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/aura/web-kernel/integration/missing-controller';
        $this->exec();
        $expect = <<<EXPECT
Missing controller 'no-such-controller' for GET /aura/web-kernel/integration/missing-controller

Params: array (
  'controller' => 'aura.web_kernel.missing_controller',
  'missing_controller' => 'no-such-controller',
)
EXPECT;
        $actual = trim($this->web_kernel->responder->content);
        $this->assertSame($expect, $actual);
    }
    
    public function testCaughtException()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/aura/web-kernel/integration/throw-exception';
        $this->exec();
        $expect = "Exception 'Exception' thrown for GET /aura/web-kernel/integration/throw-exception";
        $actual = explode(PHP_EOL, $this->web_kernel->responder->content);
        // only check the first line
        $this->assertSame($expect, $actual[0]);
    }
}
