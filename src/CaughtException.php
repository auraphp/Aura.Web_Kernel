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
use Exception;
use Aura\Web_Kernel\CaughtExceptionResponder;

/**
 *
 * A action for when the web kernel catches an exception.
 *
 * @package Aura.Web_Kernel
 *
 */
class CaughtException
{
    /**
     *
     * A web request object.
     *
     * @var Request
     *
     */
    protected $request;

    /**
     *
     * A responder object.
     *
     * @var Responder
     *
     */
    protected $responder;

    /**
     *
     * Constructor.
     *
     * @param Request $request A web request object.
     *
     * @param CaughtExceptionResponder $responder A responder object.
     *
     */
    public function __construct(
        Request $request,
        CaughtExceptionResponder $responder
    ) {
        $this->request = $request;
        $this->responder = $responder;
    }

    /**
     *
     * Invokes the action.
     *
     * @param Exception $exception The exception caught by the web kernel.
     *
     * @return null
     *
     */
    public function __invoke(Exception $exception)
    {
        $this->responder->setData(array(
            'exception' => $exception,
            'method' => $this->request->method->get(),
            'path' => $this->request->url->get(PHP_URL_PATH),
            'params' => $this->request->params->get()
        ));
        $this->responder->__invoke();
    }
}
