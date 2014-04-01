<?php
namespace Aura\Web_Kernel;

use Aura\Web\Request;
use Aura\Dispatcher\Dispatcher;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class WebKernelDispatcher
{
    public function __construct(
        Request $request,
        Dispatcher $dispatcher,
        LoggerInterface $logger = null
    ) {
        $this->request = $request;
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
    }
    
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function log($level, $message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }
    
    /**
     * 
     * Dispatch the request.
     * 
     * @return null
     * 
     */
    public function __invoke()
    {
        $controller = $this->request->params->get('controller');
        $this->logControllerValue($controller);
        $this->checkForMissingController($controller);
        try {
            $this->dispatch();
        } catch (Exception $e) {
            $this->caughtException($e);
        }
    }

    protected function logControllerValue($controller)
    {
        $message = __METHOD__ . ' to ';
        if (is_object($controller)) {
            $message .= 'object';
        } else {
            $message .= $controller;
        }
        $this->log(LogLevel::DEBUG, $message);
    }

    protected function checkForMissingController($controller)
    {
        $missing = ! is_object($controller)
                   && ! $this->dispatcher->hasObject($controller);
        if ($missing) {
            $this->log(
                LogLevel::DEBUG,
                __METHOD__ . " missing controller '$controller'"
            );
            $this->request->params['controller']  = 'aura.web_kernel.missing_controller';
            $this->request->params['missing_controller'] = $controller;
        };
    }

    protected function dispatch()
    {
        $this->dispatcher->__invoke($this->request->params->get());
    }

    protected function caughtException(Exception $e)
    {
        $this->log(
            LogLevel::DEBUG,
            __CLASS__ . " caught exception " . get_class($e)
        );

        $this->dispatcher->__invoke(array(
            'controller' => 'aura.web_kernel.caught_exception',
            'exception' => $e,
        ));
    }
}
