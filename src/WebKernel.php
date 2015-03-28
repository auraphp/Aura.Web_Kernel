<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\Web_Kernel;

use Aura\Web\ResponseSender;

/**
 *
 * A kernel for Aura web projects.
 *
 * @package Aura.Web_Kernel
 *
 */
class WebKernel
{
    /**
     *
     * Web router logic.
     *
     * @var WebKernelRouter
     *
     */
    protected $router;

    /**
     *
     * Web dispatcher logic.
     *
     * @var WebKernelDispatcher
     *
     */
    protected $dispatcher;

    /**
     *
     * Web response-sending logic.
     *
     * @var ResponseSender
     *
     */
    protected $response_sender;

    /**
     *
     * Constructor.
     *
     * @param WebKernelRouter $router Web router logic.
     *
     * @param WebKernelDispatcher $dispatcher Web dispatcher logic.
     *
     * @param ResponseSender $response_sender Web response-sending logic.
     *
     */
    public function __construct(
        WebKernelRouter $router,
        WebKernelDispatcher $dispatcher,
        ResponseSender $response_sender
    ) {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
        $this->response_sender = $response_sender;
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
     * Routes the request through the dispatcher and sends the response.
     *
     * @return null
     *
     */
    public function __invoke()
    {
        $this->router->__invoke();
        $this->dispatcher->__invoke();
        $this->response_sender->__invoke();
    }
}
