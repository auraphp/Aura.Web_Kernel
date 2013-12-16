<?php
namespace Aura\Web_Kernel;

use Aura\Web\Request;
use Aura\Web\Response;
use Exception;

class MissingRoute
{
    protected $request;
    
    protected $response;
    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    
    public function __invoke($missing_controller)
    {
        $content = 'No route for '
                 . $this->request->method->get() . ' '
                 . $this->request->url->get(PHP_URL_PATH)
                 . PHP_EOL;
        $this->response->status->set('404', 'Not Found');
        $this->response->content->set($content);
        $this->response->content->setType('text/plain');
    }
}
