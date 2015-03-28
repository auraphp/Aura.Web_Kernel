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

/**
 *
 * A controller for when the web kernel cannot find a route for the request.
 *
 * @package Aura.Web_Kernel
 *
 */
class MissingRoute
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
        MissingRouteResponder $responder
    ) {
        $this->request = $request;
        $this->responder = $responder;
    }

    /**
     *
     * Invokes the controller.
     *
     * @return null
     *
     */
    public function __invoke()
    {
        $this->responder->setData(array(
            'method' => $this->request->method->get(),
            'path' => $this->request->url->get(PHP_URL_PATH),
        ));
        $this->responder->__invoke();
    }
}
