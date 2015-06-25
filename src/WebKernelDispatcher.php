<?php
/**
 *
 * This file is part of Aura for PHP.
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
        $objectParam = $this->dispatcher->getObjectParam();
        if (!$objectParam) {
            $objectParam = 'action';
        }
        $action = $this->request->params->get($objectParam);
        $this->logControllerValue($action);
        $this->checkForMissingController($action);
        try {
            $this->dispatcher->__invoke($this->request->params->get());
        } catch (Exception $e) {
            $this->caughtException($e);
        }
    }

    /**
     *
     * Logs the action to be dispatched to.
     *
     * @param mixed $action The action to be dispatched to.
     *
     * @return null
     *
     */
    protected function logControllerValue($action)
    {
        $message = __METHOD__ . ' to ';
        if (is_object($action)) {
            $message .= 'object';
        } else {
            $message .= $action;
        }
        $this->logger->debug($message);
    }

    /**
     *
     * Check for a missing action.
     *
     * @param mixed $action The action to be dispatched to.
     *
     * @return null
     *
     */
    protected function checkForMissingController($action)
    {
        $exists = is_object($action)
               || $this->dispatcher->hasObject($action);
        if ($exists) {
            return;
        }

        $this->logger->debug(__METHOD__ . " missing action '$action'");
        $this->request->params['action']  = 'aura.web_kernel.missing_action';
        $this->request->params['missing_action'] = $action;
    }

    /**
     *
     * Caught an exception while dispatching.
     *
     * @param Exception $e The caught exception.
     *
     * @return null
     *
     */
    protected function caughtException(Exception $e)
    {
        $this->logger->debug(__CLASS__ . " caught exception " . get_class($e));
        $this->dispatcher->__invoke(array(
            'action' => 'aura.web_kernel.caught_exception',
            'exception' => $e,
        ));
    }
}
