<?php
namespace Aura\Web_Kernel;

class WebKernel extends ProjectKernel
{
    public function __invoke()
    {
        parent::__invoke();
        
        $this->logger     = $this->di->get('logger');
        $this->request    = $this->di->get('web_request');
        $this->response   = $this->di->get('web_response');
        $this->router     = $this->di->get('web_router');
        $this->dispatcher = $this->di->get('web_dispatcher');
        
        $this->request();
        $this->response();
    }
    
    protected function request()
    {
        $this->logger->debug(__METHOD__ . ' routing');
        
        $route = $this->router->match(
            $this->request->url->get(PHP_URL_PATH),
            $this->request->server->get()
        );
        
        if ($route) {
            $this->request->params->set($route->params);
        } else {
            $this->logger->debug(__METHOD__ . ' routing: no route');
            $this->request->params->set(array(
                'controller' => 'no_route',
            ));
        }

        $routes = $this->router->getLog();
        if (! $routes) {
            $this->logger->debug(__METHOD__ . ' routing: no routes in router');
        } else {
            foreach ($routes as $route) {
                foreach ($route->debug as $message) {
                    $name = $route->name
                          ? $route->name
                          : $this->request->method->get() . ' ' . $route->path;
                    $message = __METHOD__ . " routing: $name $message";
                    $this->logger->debug($message);
                }
            }
        }
        
        try {
            $this->logger->debug(__METHOD__ . ' dispatch');
            $this->dispatcher->__invoke($this->request->params->get());
        } catch (\Aura\Dispatcher\Exception\ObjectNotDefined $e) {
            $this->logger->debug(__METHOD__ . ' dispatch: no controller');
            $dispatcher->__invoke(array(
                'controller' => 'no_controller',
            ));
        }
    }
    
    protected function response()
    {
        $this->logger->debug(__METHOD__);
        
        // send the response status line
        header(
            $this->response->status->get(),
            true,
            $this->response->status->getCode()
        );
        
        // send non-cookie headers
        foreach ($this->response->headers->get() as $label => $value) {
            header($label, $value);
        }
        
        // send cookies
        foreach ($this->response->cookies->get() as $name => $cookie) {
            setcookie(
                $name,
                $cookie['value'],
                $cookie['expire'],
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httponly']
            );
        }
        
        // send content, and done!
        echo $this->response->content->get();
    }
}
