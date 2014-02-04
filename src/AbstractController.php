<?php
namespace Aura\Web_Kernel;

use Aura\Web\Request;
use Aura\Web\Response;

abstract class AbstractController
{
    protected $request;
    
    protected $response;
    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->init();
    }
    
    protected function init()
    {
    }
}
