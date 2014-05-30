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
 * A controller for when the web kernel cannot find a controller for a route.
 *
 * @package Aura.Web_Kernel
 *
 */
class MissingController extends AbstractController
{
    /**
     *
     * Invokes the controller.
     *
     * @param string $missing_controller The name of the missing controller.
     *
     * @return null
     *
     */
    public function __invoke($missing_controller)
    {
        $content = "Missing controller '$missing_controller' for "
                 . $this->request->method->get() . ' '
                 . $this->request->url->get(PHP_URL_PATH) . PHP_EOL . PHP_EOL
                 . 'Params: ' . var_export($this->request->params->get(), true)
                 . PHP_EOL;
        $this->response->status->set('404', 'Not Found');
        $this->response->content->set($content);
        $this->response->content->setType('text/plain');
    }
}
