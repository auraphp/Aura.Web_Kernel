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
use Aura\Web\Response;

/**
 *
 * An abstract web kernel controller.
 *
 * You should probably *not* extend this for your own controllers. Create your
 * own base controller so that you can avoid a dependency on this package.
 *
 * @package Aura.Web_Kernel
 *
 */
abstract class AbstractController
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
     * A web (not HTTP!) response object.
     *
     * @var Request
     *
     */
    protected $response;

    /**
     *
     * Constructor.
     *
     * @param Request $request A web request object.
     *
     * @param Response $response A web response object.
     *
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
