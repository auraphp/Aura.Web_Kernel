<?php
namespace Aura\Web_Kernel;

class MissingController extends AbstractController
{
    public function __invoke($missing_controller)
    {
        $content = "Missing controller '$missing_controller' for "
                 . $this->request->method->get() . ' '
                 . $this->request->url->get(PHP_URL_PATH) . PHP_EOL . PHP_EOL
                 . 'Params: ' . var_export($this->request->params->get(), true)
                 . PHP_EOL;
        $this->response->status->set('404', 'Not Found');
        $this->response->content->set($content);
        $this->response->content->setType('text/plain');
    }
}
