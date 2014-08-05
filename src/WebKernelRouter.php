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

/**
 *
 * Web kernel router logic.
 *
 * @package Aura.Web_Kernel
 *
 */
class WebKernelRouter
{
    /**
     *
     * A web (not HTTP!) request object.
     *
     * @var Request
     *
     */
    protected $request;

    /**
     *
     * A web router.
     *
     * @var Router
     *
     */
    protected $router;

    /**
     *
     * A PSR-3 logger.
     *
     * @var LoggerInterface
     *
     */
    protected $logger;

    /**
     *
     * Constructor.
     *
     * @param Request $request A web request object.
     *
     * @param Router $router A web router.
     *
     * @param LoggerInterface $logger A PSR-3 logger.
     *
     */
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
     * Determines the route and inserts the route params into the request.
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
            $this->request->params['action'] = 'aura.web_kernel.missing_route';
        }
    }

    /**
     *
     * Magic get for read-only properties.
     *
     * @param string $key The property name.
     *
     * @return mixed The property.
     *
     */
    public function __get($key)
    {
        return $this->$key;
    }


    /**
     *
     * Gets the path from the URL.
     *
     * @return string
     *
     */
    protected function getPath()
    {
        $path = $this->request->url->get(PHP_URL_PATH);
        return $this->removeScriptFromPath($path);
    }

    /**
     *
     * Removes the bootstrap script (if any) from the URL path.
     *
     * @param string $path The URL path.
     *
     * @return string
     *
     */
    protected function removeScriptFromPath($path)
    {
        $pos = strpos($path, '/index.php');
        if ($pos !== false) {
            $path = substr($path, $pos + 10);
            $path = '/' . ltrim($path, '/');
        }
        return $path;
    }

    /**
     *
     * Given a URL path, gets a matching route from the router.
     *
     * @param string $path The URL path.
     *
     * @return string
     *
     */
    protected function getRoute($path)
    {
        $verb = $this->request->method->get();
        $this->logger->debug(__CLASS__ . " $verb $path");
        $route = $this->router->match($path, $this->request->server->get());
        $this->logRoutesTried();
        return $route;
    }

    /**
     *
     * Logs the different routes tried by the router.
     *
     * @return null
     *
     */
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
