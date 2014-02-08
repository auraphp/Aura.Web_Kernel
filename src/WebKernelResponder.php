<?php
namespace Aura\Web_Kernel;

use Aura\Web\Response;
use Monolog\Logger;

class WebKernelResponder
{
    protected $response;
    
    protected $logger;
    
    public function __construct(
        Response $response,
        Logger $logger
    ) {
        $this->response = $response;
        $this->logger = $logger;
    }
    
    /**
     * 
     * Send the response.
     * 
     * @return null
     * 
     */
    public function __invoke()
    {
        $this->logger->debug(__METHOD__);
        
        // send the response status line
        $this->header(
            $this->response->status->get(),
            true,
            $this->response->status->getCode()
        );
        
        // send non-cookie headers
        foreach ($this->response->headers->get() as $label => $value) {
            // the header() function itself prevents header injection attacks
            $this->header("$label: $value");
        }
        
        // send cookies
        foreach ($this->response->cookies->get() as $name => $cookie) {
            $this->setcookie(
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
    
    /**
     * 
     * Implemented so we can override it in testing.
     * 
     * @param string $string The header value to send.
     * 
     * @param bool $replace The header should replace a previous similar header
     * 
     * @param int $http_response_code Forces the HTTP response code to the specified value. 
     * 
     * @return null
     * 
     */
    protected function header($string, $replace = true, $http_response_code = '')
    {
        if ($http_response_code) {
            header($string, $replace, $http_response_code);
        } else {
            header($string, $replace);
        }
    }
    
    /**
     * 
     * Implemented so we can override it in testing.
     * 
     * @param string $string The header value to send.
     * 
     * @return null
     * 
     */
    protected function setcookie($name, $value, $expire, $path, $domain, $secure, $httponly)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}
