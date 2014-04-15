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
     * Web responder logic.
     * 
     * @var WebKernelResponder
     * 
     */
    protected $responder;
    
    /**
     * 
     * Constructor.
     * 
     * @param WebKernelRouter $router Web router logic.
     * 
     * @param WebKernelDispatcher $dispatcher Web dispatcher logic.
     * 
     * @param WebKernelResponder $responder Web responder logic.
     * 
     */
    public function __construct(
        WebKernelRouter $router,
        WebKernelDispatcher $dispatcher,
        WebKernelResponder $responder
    ) {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
        $this->responder = $responder;
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
        $this->responder->__invoke();
    }
}
