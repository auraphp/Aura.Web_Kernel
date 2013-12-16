<?php
namespace Aura\Web_Kernel;

class MissingRoute extends AbstractController
{
    public function __invoke()
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
