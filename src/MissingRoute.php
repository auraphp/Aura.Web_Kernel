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
 * A controller for when the web kernel cannot find a route for the request.
 *
 * @package Aura.Web_Kernel
 *
 */
class MissingRoute extends AbstractController
{
    /**
     *
     * Invokes the controller.
     *
     * @return null
     *
     */
    public function __invoke()
    {
        $content = 'No route for '
                 . $this->request->method->get() . ' '
                 . $this->request->url->get(PHP_URL_PATH)
                 . PHP_EOL;
        $this->response->status->set('404', 'Not Found');
        $this->response->content->set($content);
        $this->response->content->setType('text/plain');
    }
}
