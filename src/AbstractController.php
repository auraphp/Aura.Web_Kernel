<?php
namespace Aura\Web_Kernel;

abstract class AbstractController
{
    protected $request;
    
    protected $response;
    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
