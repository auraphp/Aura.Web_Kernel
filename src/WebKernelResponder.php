<?php
namespace Aura\Web_Kernel;

use Aura\Web\Response;
use Psr\Log\LoggerInterface;

class WebKernelResponder
{
    protected $response;
    
    protected $logger;
    
    public function __construct(
        Response $response,
        LoggerInterface $logger
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
        $this->logger->debug(__CLASS__);
        $this->sendStatus();
        $this->sendHeaders();
        $this->sendCookies();
        $this->sendContent();
    }
    
    protected function sendStatus()
    {
        $this->header(
            $this->response->status->get(),
            true,
            $this->response->status->getCode()
        );
    }

    protected function sendHeaders()
    {
        foreach ($this->response->headers->get() as $label => $value) {
            $this->header("$label: $value");
        }
    }

    protected function sendCookies()
    {
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
    }

    protected function sendContent()
    {
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
     * @return null
     * 
     */
    protected function setcookie(
        $name,
        $value,
        $expire,
        $path,
        $domain,
        $secure,
        $httponly
    ) {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}
