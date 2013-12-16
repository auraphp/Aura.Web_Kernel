<?php
namespace Aura\Web_Kernel;

use Aura\Web\Request;
use Aura\Web\Response;
use Exception;

class CaughtException
{
    protected $request;
    
    protected $response;
    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    
    public function __invoke(Exception $exception)
    {
        $content = "Exception '" . get_class($exception) . "' thrown for "
                 . $this->request->method->get() . ' '
                 . $this->request->url->get(PHP_URL_PATH) . PHP_EOL . PHP_EOL
                 . 'Params: ' . var_export($this->request->params->get(), true)
                 . PHP_EOL . PHP_EOL
                 . (string) $exception
                 . PHP_EOL;
        $this->response->status->set('500', 'Server Error');
        $this->response->content->set($content);
        $this->response->content->setType('text/plain');
    }
}
