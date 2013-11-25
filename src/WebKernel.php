<?php
namespace Aura\Web_Kernel;

use Aura\Project_Kernel\ProjectKernel;

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
        $this->requestRoute();
        $this->requestDispatch();
    }
    
    protected function requestRoute()
    {
        // get the http verb, the path, and the server vars
        $verb = $this->request->method->get();
        $path = $this->request->url->get(PHP_URL_PATH);
        $server = $this->request->server->get();
        
        // log that we're routing, and try to get a route
        $this->logger->debug(__METHOD__ . " $verb $path");
        $route = $this->router->match($path, $server);
        
        // log the routes that were tried for matches
        $routes = $this->router->getDebug();
        if (! $routes) {
            $this->logger->debug(__METHOD__ . ' no routes in router');
        } else {
            foreach ($routes as $tried) {
                foreach ($tried->debug as $message) {
                    $name = $tried->name
                          ? $tried->name
                          : $this->request->method->get() . ' ' . $tried->path;
                    $message = __METHOD__ . " $name $message";
                    $this->logger->debug($message);
                }
            }
        }
        
        // did we find a matching route?
        if ($route) {
            // yes, retain the route params
            $this->request->params->set($route->params);
        } else {
            // no, log it and set a controller name
            $this->logger->debug(__METHOD__ . ' missing route');
            $this->request->params['controller'] = 'aura.web_kernel.missing_route';
        }
    }
    
    protected function requestDispatch()
    {
        $controller = $this->request->params->get('controller');
        
        $missing_controller = ! is_object($controller)
                           && ! $this->dispatcher->hasObject($controller);
        if ($missing_controller) {
            $this->logger->debug(__METHOD__ . " missing controller '$controller'");
            $this->request->params['controller']  = 'aura.web_kernel.missing_controller';
            $this->request->params['missing_controller'] = $controller;
        };
        
        $message = __METHOD__ . ' to ';
        if (is_object($controller)) {
            $message .= 'object';
        } else {
            $message .= $controller;
        }
        $this->logger->debug($message);
        
        try {
            $this->dispatcher->__invoke($this->request->params->get());
        } catch (Exception $e) {
            $this->logger->debug(__METHOD__ . " caught exception " . get_class($e));
            $dispatcher->__invoke(array(
                'controller' => 'aura.web_kernel.caught_exception',
                'exception' => $e,
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
            // the header() function itself prevents header injection attacks
            header("$label: $value");
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
