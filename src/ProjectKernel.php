<?php
namespace Aura\Web_Kernel;

/**
 * Eventually extract this to its own package as a base for Cli_Kernel.
 */
class ProjectKernel
{
    protected $di;
    
    protected $base;
    
    protected $mode;
    
    protected $packages = array(
        'library' => array(),
        'kernel' => array(),
    );
    
    protected $config_log = array();
    
    public function __construct($di, $base, $mode)
    {
        $this->di   = $di;
        $this->base = $base;
        $this->mode = $mode;
    }
    
    public function __invoke()
    {
        $this->loadPackages();
        $this->loadConfig('define');
        $this->di->lock();
        $this->loadConfig('modify');
        
        $logger = $this->di->get('logger');
        foreach ($this->config_log as $messages) {
            foreach ($messages as $message) {
                $logger->debug(__CLASS__ . " config {$message}");
            }
        }
    }
    
    protected function loadPackages()
    {
        $file = str_replace(
            '/',
            DIRECTORY_SEPARATOR,
            "{$this->base}/vendor/composer/installed.json"
        );
        
        $installed = json_decode(file_get_contents($file));
        foreach ($installed as $package) {
            if (! isset($package->extra->aura->type)) {
                continue;
            }
            $type = $package->extra->aura->type;
            $dir = "{$this->base}/vendor/{$package->name}";
            $this->packages[$type][$package->name] = $dir;
        }
    }
    
    protected function loadConfig($type)
    {
        // the config includer
        $includer = $this->di->newInstance('Aura\Includer\Includer');
        
        // pass DI container to the config files
        $includer->setVars(array('di' => $this->di));
        
        // always load the default configs
        $includer->setFiles(array(
            "config/default/{$type}.php",
            "config/default/{$type}/*.php",
        ));
        
        // load any non-default configs
        if ($this->mode != 'default') {
            $includer->addFiles(array(
                "config/{$this->mode}/{$type}.php",
                "config/{$this->mode}/{$type}/*.php",
            ));
        }
        
        // load in this order: library packages, kernel packages, project
        $includer->addDirs($this->packages['library']);
        $includer->addDirs($this->packages['kernel']);
        $includer->addDir($this->base);
        
        // actually do the loading
        $includer->load();
        
        // retain the debug messages for logging
        $this->config_log[] = $includer->getDebug();
    }
}
