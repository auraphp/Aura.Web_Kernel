<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\Web_Kernel;

/**
 *
 * A action for when the web kernel cannot find a action for a route.
 *
 * @package Aura.Web_Kernel
 *
 */
class MissingRouteResponder extends AbstractResponder
{
    /**
     *
     * Invokes the responder.
     *
     * @return null
     *
     */
    public function __invoke()
    {
        $content = "No route for {$this->data['method']} {$this->data['path']}"
                 . PHP_EOL;
        $this->response->status->set('404', 'Not Found');
        $this->response->content->set($content);
        $this->response->content->setType('text/plain');
    }
}
