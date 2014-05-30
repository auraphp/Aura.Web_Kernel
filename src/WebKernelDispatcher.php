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

use Aura\Web\Request;
use Aura\Dispatcher\Dispatcher;
use Exception;
use Psr\Log\LoggerInterface;

/**
 *
 * Web kernel dispatcher logic.
 *
 * @package Aura.Web_Kernel
 *
 */
class WebKernelDispatcher
{
    /**
     *
     * A web (not HTTP!) request object.
     *
     * @var Request
     *
     */
    protected $request;

    /**
     *
     * A web dispatcher.
     *
     * @var Dispatcher
     *
     */
    protected $dispatcher;

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
     * @param Request $request A web request object.
     *
     * @param Dispatcher $dispatcher A web dispatcher.
     *
     * @param LoggerInterface $logger A PSR-3 logger.
     *
     */
    public function __construct(
        Request $request,
        Dispatcher $dispatcher,
        LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
    }

    /**
     *
     * Dispatches the request.
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
            $this->dispatcher->__invoke($this->request->params->get());
        } catch (Exception $e) {
            $this->caughtException($e);
        }
    }

    /**
     *
     * Logs the controller to be dispatched to.
     *
     * @param mixed $controller The controller to be dispatched to.
     *
     * @return null
     *
     */
    protected function logControllerValue($controller)
    {
        $message = __METHOD__ . ' to ';
        if (is_object($controller)) {
            $message .= 'object';
        } else {
            $message .= $controller;
        }
        $this->logger->debug($message);
    }

    /**
     *
     * Check for a missing controller.
     *
     * @param mixed $controller The controller to be dispatched to.
     *
     * @return null
     *
     */
    protected function checkForMissingController($controller)
    {
        $exists = is_object($controller)
               || $this->dispatcher->hasObject($controller);
        if ($exists) {
            return;
        }

        $this->logger->debug(__METHOD__ . " missing controller '$controller'");
        $this->request->params['controller']  = 'aura.web_kernel.missing_controller';
        $this->request->params['missing_controller'] = $controller;
    }

    /**
     *
     * Caught an exception while dispatching.
     *
     * @param Exception $exception The caught exception.
     *
     * @return null
     *
     */
    protected function caughtException(Exception $e)
    {
        $this->logger->debug(__CLASS__ . " caught exception " . get_class($e));
        $this->dispatcher->__invoke(array(
            'controller' => 'aura.web_kernel.caught_exception',
            'exception' => $e,
        ));
    }
}
