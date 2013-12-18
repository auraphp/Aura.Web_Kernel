<?php
namespace Aura\Web_Kernel;

class IntegrationResponder extends WebKernelResponder
{
    protected $headers = array();
    protected $cookies = array();
    protected $content;
    
    public function __invoke()
    {
        // retain output instead of echoing
        ob_start();
        parent::__invoke();
        $this->content = ob_get_clean();
    }
    
    public function __get($key)
    {
        return $this->$key;
    }
    
    protected function header($string)
    {
        // for test coverage
        parent::header(null);
        
        // retain the string
        $this->headers[] = $string;
    }
    
    protected function setcookie($name, $value, $expire, $path, $domain, $secure, $httponly)
    {
        // for test coverage
        parent::setcookie(null, null, null, null, null, null, null);
        
        // retain the cookie
        $this->cookies[] = array(
            'name'     => $name,
            'value'    => $value,
            'expire'   => $expire,
            'path'     => $path,
            'domain'   => $domain,
            'secure'   => $secure,
            'httponly' => $httponly,
        );
    }
}
