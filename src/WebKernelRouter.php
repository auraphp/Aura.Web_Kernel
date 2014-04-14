<?php
/**
 * 
 * This file is part of Aura for PHP.
 * 
 * @package Aura.Web_Kernel
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 */
namespace Aura\Web_Kernel;

use Aura\Web\Request;
use Aura\Router\Router;
use Psr\Log\LoggerInterface;

class WebKernelRouter
{
    protected $request;
    
    protected $router;

    protected $logger;

    public function __construct(
        Request $request,
        Router $router,
        LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->router = $router;
        $this->logger = $logger;
    }
    
    /**
     * 
     * Insert the route params into the request.
     * 
     * @return null
     * 
     */
    public function __invoke()
    {
        $path = $this->getPath();
        $route = $this->getRoute($path);
        if ($route) {
            $this->request->params->set($route->params);
        } else {
            $this->logger->debug(__CLASS__ . ' missing route');
            $this->request->params['controller'] = 'aura.web_kernel.missing_route';
        }
    }

    protected function getPath()
    {
        $path = $this->request->url->get(PHP_URL_PATH);
        return $this->removeScriptFromPath($path);
    }

    protected function removeScriptFromPath($path)
    {
        $pos = strpos($path, '/index.php');
        if ($pos !== false) {
            $path = substr($path, $pos + 10);
            $path = '/' . ltrim($path, '/');
        }
        return $path;
    }

    protected function getRoute($path)
    {
        $verb = $this->request->method->get();
        $this->logger->debug(__CLASS__ . " $verb $path");
        $route = $this->router->match($path, $this->request->server->get());
        $this->logRoutesTried();
        return $route;
    }

    protected function logRoutesTried()
    {
        $verb = $this->request->method->get();
        $routes = $this->router->getDebug();
        foreach ($routes as $tried) {
            foreach ($tried->debug as $message) {
                $name = $tried->name
                      ? $tried->name
                      : $verb . ' ' . $tried->path;
                $message = __CLASS__ . " $name $message";
                $this->logger->debug($message);
            }
        }
    }
}
