<?php
namespace Aura\Web_Kernel;

use Aura\Project_Kernel\Factory;
use Aura\Web\FakeResponseSender;

class WebKernelTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        FakeResponseSender::reset();
    }

    // equivalent to the web/index.php file
    protected function index()
    {
        $_SERVER['HTTP_HOST'] = 'example.com';

        $path = __DIR__;
        $di = (new Factory)->newContainer(
            $path,
            'kernel',
            "$path/composer.json",
            "$path/vendor/composer/installed.json"
        );

        $web_kernel = $di->newInstance('Aura\Web_Kernel\WebKernel');
        $web_kernel();

        return $web_kernel;
    }

    public function testHelloWorld()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/aura/web-kernel/integration/hello';
        $web_kernel = $this->index();

        $expect = 'Hello World!';
        $actual = FakeResponseSender::$content;
        $this->assertSame($expect, $actual);
    }

    public function testHelloWorldViaIndexPhp()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/index.php/aura/web-kernel/integration/hello';
        $web_kernel = $this->index();

        $expect = 'Hello World!';
        $actual = FakeResponseSender::$content;
        $this->assertSame($expect, $actual);
    }

    public function testMissingRoute()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/aura/web-kernel/integration/missing-route';
        $web_kernel = $this->index();

        $expect = 'No route for GET /aura/web-kernel/integration/missing-route';
        $actual = trim(FakeResponseSender::$content);
        $this->assertSame($expect, $actual);
    }

    public function testMissingContoller()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/aura/web-kernel/integration/missing-controller';
        $web_kernel = $this->index();

        $expect = <<<EXPECT
Missing controller 'no-such-controller' for GET /aura/web-kernel/integration/missing-controller

Params: array (
  'controller' => 'aura.web_kernel.missing_controller',
  'missing_controller' => 'no-such-controller',
)
EXPECT;
        $actual = trim(FakeResponseSender::$content);
        $this->assertSame($expect, $actual);
    }

    public function testCaughtException()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/aura/web-kernel/integration/throw-exception';
        $web_kernel = $this->index();

        $expect = "Exception 'Exception' thrown for GET /aura/web-kernel/integration/throw-exception";
        $actual = explode(PHP_EOL, FakeResponseSender::$content);
        // only check the first line
        $this->assertSame($expect, $actual[0]);
    }
}
