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

use Aura\Web\Response;
use Psr\Log\LoggerInterface;

/**
 *
 * Web kernel responder logic.
 *
 * @package Aura.Web_Kernel
 *
 */
class WebKernelResponder
{
    /**
     *
     * A web (not HTTP!) response object.
     *
     * @var Request
     *
     */
    protected $response;

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
     * @param Response $response A web response object.
     *
     * @param LoggerInterface $logger A PSR-3 logger.
     *
     */
    public function __construct(
        Response $response,
        LoggerInterface $logger
    ) {
        $this->response = $response;
        $this->logger = $logger;
    }

    /**
     *
     * Sends the response.
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

    /**
     *
     * Sends the HTTP status.
     *
     * @return null
     *
     */
    protected function sendStatus()
    {
        $this->header(
            $this->response->status->get(),
            true,
            $this->response->status->getCode()
        );
    }

    /**
     *
     * Sends the HTTP non-cookie headers.
     *
     * @return null
     *
     */
    protected function sendHeaders()
    {
        foreach ($this->response->headers->get() as $label => $value) {
            $this->header("$label: $value", false);
        }
    }

    /**
     *
     * Sends the HTTP cookie headers.
     *
     * @return null
     *
     */
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

    /**
     *
     * Sends the HTTP body.
     *
     * @return null
     *
     */
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
     * @param bool $replace Replace previous header?
     *
     * @param int $http_response_code Use this HTTP response code.
     *
     * @return null
     *
     */
    protected function header(
        $string,
        $replace = true,
        $http_response_code = null
    ) {
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
     * @param string $name The name of the cookie.
     *
     * @param string $value The value of the cookie.
     *
     * @param int|string $expire The Unix timestamp after which the cookie
     * expires.  If non-numeric, the method uses strtotime() on the value.
     *
     * @param string $path The path on the server in which the cookie will be
     * available on.
     *
     * @param string $domain The domain that the cookie is available on.
     *
     * @param bool $secure Indicates that the cookie should only be
     * transmitted over a secure HTTPS connection.
     *
     * @param bool $httponly When true, the cookie will be made accessible
     * only through the HTTP protocol. This means that the cookie won't be
     * accessible by scripting languages, such as JavaScript.
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

    public function getResponse()
    {
        return $this->response;
    }
}
