<?php
namespace Aura\Web_Kernel;

class WebKernel
{
    protected $di;
    
    protected $base;
    
    protected $mode;
    
    protected $packages = array(
        "config" => array(
            "library" => array(),
            "kernel" => array(),
        ),
        "routes" => array(
            "library" => array(),
            "kernel" => array(),
        ),
    );
    
    protected $log_config;
    
    public function __construct($di, $base, $mode)
    {
        $this->di   = $di;
        $this->base = $base;
        $this->mode = $mode;
    }
    
    public function __invoke()
    {
        $this->loadPackages();
        $this->loadConfig();
        $this->setProperties();
        $this->logConfig();
        $this->loadRoutes();
        $this->route();
        $this->dispatch();
        $this->respond();
    }
    
    protected function loadPackages()
    {
        $file = str_replace(
            "/",
            DIRECTORY_SEPARATOR,
            "{$this->base}/composer/installed.json"
        );
        
        $installed = json_decode(file_get_contents($file));
        foreach ($installed as $package) {
            if (! isset($package->extra->aura->type)) {
                continue;
            }
            $type = $package->extra->aura->type;
            $dir = "{$this->base}/vendor/{$package->name}";
            $this->packages["config"][$type][] = "$dir/config";
            $this->packages["routes"][$type][] = "$dir/routes";
        }
    }
    
    protected function loadConfig()
    {
        // the config includer
        $includer = $this->di->newInstance("Aura\Includer\Includer");
        $includer->setVars(array("di" => $this->di));
        
        // package config (library, kernel)
        $includer->setFiles("default.php");
        if ($this->mode != "default") {
            $includer->setFiles("{$this->mode}.php");
        }
        foreach ($this->packages["config"] as $type => $dirs) {
            $includer->setDirs($dirs);
            $includer->load();
            $this->log_config[$type] = $includer->getLog();
        }
        
        // project config
        $includer->setDirs(array("{$this->base}/config"));
        $includer->setFiles(array("default/*.php"));
        if ($this->mode != "default") {
            $includer->setFiles(array("{$this->mode}/*.php"));
        }
        $includer->load();
        $this->log_config["project"] = $includer->getLog();
        
        // done!
        $this->di->lock();
    }
    
    protected function setProperties()
    {
        $this->logger       = $this->di->get("web_logger");
        $this->request      = $this->di->get("web_request");
        $this->response     = $this->di->get("web_response");
        $this->router       = $this->di->get("web_router");
        $this->dispatcher   = $this->di->get("web_dispatcher");
    }
    
    protected function logConfig()
    {
        $this->logger->debug(__METHOD__);
        foreach ($this->log_config as $type => $messages) {
            foreach ($messages as $message) {
                $message = __METHOD__ . " {$type} " . $message;
                $this->logger->debug($message);
            }
        }
    }
    
    protected function loadRoutes()
    {
        $this->logger->debug(__METHOD__);
        
        // the routes includer
        $includer = $this->di->newInstance("Aura\Includer\Includer");
        $includer->setVars(array("router" => $this->router));
        $includer->setFiles("default.php");
        if ($this->mode != "default") {
            $includer->setFiles("{$this->mode}.php");
        }
        
        // package routes (library, kernel)
        foreach ($this->packages["routes"] as $type => $dirs) {
            $includer->setDirs($dirs);
            $includer->load();
            foreach ($includer->getLog() as $message) {
                $message = __METHOD__ . " {$type} " . $message;
            }
        }
        
        // project routes
        $includer->setDirs(array("{$this->base}/routes"));
        $includer->setFiles(array("default/*.php"));
        if ($this->mode != "default") {
            $includer->setFiles(array("{$this->mode}/*.php"));
        }
        $includer->load();
        foreach ($includer->getLog() as $message) {
            $message = __METHOD__ . " project " . $message;
        }
    }
    
    protected function route()
    {
        $this->logger->debug(__METHOD__);
        
        $route = $this->router->match(
            $this->request->url->getPath(),
            $this->request->server->get()
        );
        
        if ($route) {
            $this->request->params->set($route->params);
        }

        foreach ($this->router->getLog() as $route) {
            foreach ($route->getDebug() as $message) {
                $message = __METHOD__
                         . " " . ($route->name ? $route->name : $route->path)
                         . " " . $message;
                $this->logger->debug($message);
            }
        }
    }
    
    protected function dispatch()
    {
        $this->logger->debug(__METHOD__);
        
        try {
            $this->dispatcher->__invoke($this->request->params->get());
        } catch (\Aura\Dispatcher\Exception\ObjectNotDefined $e){
            $dispatcher->__invoke(array(
                "controller" => "not_found",
                "request" => $this->request,
                "response" => $this->response,
            ));
        }
    }
    
    protected function respond()
    {
        $this->logger->debug(__METHOD__);
        
        // send the response status line
        header($this->response->status->get(), true, $this->response->status->getCode());

        // send non-cookie headers
        foreach ($this->response->headers->get() as $label => $value) {
            header($label, $value);
        }

        // send cookies
        foreach ($this->response->cookies->get() as $name => $cookie) {
            setcookie(
                $name,
                $cookie["value"],
                $cookie["expire"],
                $cookie["path"],
                $cookie["domain"],
                $cookie["secure"],
                $cookie["httponly"]
            );
        }

        // send content, and done!
        echo $this->response->content->get();
    }
}
