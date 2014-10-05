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

/**
 *
 * A action for when the web kernel cannot find a action for a route.
 *
 * @package Aura.Web_Kernel
 *
 */
class MissingAction
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
        MissingActionResponder $responder
    ) {
        $this->request = $request;
        $this->responder = $responder;
    }

    /**
     *
     * Invokes the action.
     *
     * @param string $missing_action The name of the missing action.
     *
     * @return null
     *
     */
    public function __invoke($missing_action)
    {
        $this->responder->setData(array(
            'missing_action' => $missing_action,
            'method' => $this->request->method->get(),
            'path' => $this->request->url->get(PHP_URL_PATH),
            'params' => $this->request->params->get(),
        ));
        $this->responder->__invoke();
    }
}
