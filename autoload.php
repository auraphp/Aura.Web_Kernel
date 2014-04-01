<?php
spl_autoload_register(function ($class) {

    $ns  = 'Aura\Web_Kernel';

    $dir = __DIR__ . DIRECTORY_SEPARATOR;
    $prefix_paths = array(
        "$ns\\" => array(
            $dir . 'src',
            $dir . 'tests' . DIRECTORY_SEPARATOR . 'src',
        ),
        "$ns\\_Config\\" => array(
            $dir . 'config',
        ),
    );
    
    // go through the directories to find classes
    foreach ($prefix_paths as $prefix => $paths) {

        // does the requested class match the namespace prefix?
        $prefix_len = strlen($prefix);
        if (substr($class, 0, $prefix_len) !== $prefix) {
            continue;
        }
        
        // strip the prefix off the class
        $suffix = substr($class, $prefix_len);
        
        // a partial filename
        $part = str_replace('\\', DIRECTORY_SEPARATOR, $suffix) . '.php';
        
        foreach ($paths as $path) {
            $file = $path . DIRECTORY_SEPARATOR . $part;
            if (is_readable($file)) {
                require $file;
                return;
            }
        }
    }
});
