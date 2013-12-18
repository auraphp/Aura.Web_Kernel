<?php
namespace Aura\Web_Kernel;

class WebKernelTest extends \PHPUnit_Framework_TestCase
{
    protected function exec()
    {
        $_ENV['AURA_CONFIG_MODE'] = 'integration';
        require dirname(dirname(__DIR__)) . '/scripts/kernel.php';
        $this->web_kernel = $web_kernel;
    }
    
    public function test()
    {
        $_SERVER['REQUEST_METHOD'] = 'FAKE';
        $_SERVER['REQUEST_URI'] = '/';
        $this->exec();
        var_dump($this->web_kernel->responder->content);
    }
}
