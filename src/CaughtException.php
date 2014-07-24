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

use Exception;

/**
 *
 * A action for when the web kernel catches an exception.
 *
 * @package Aura.Web_Kernel
 *
 */
class CaughtException extends AbstractAction
{
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
        $content = "Exception '" . get_class($exception) . "' thrown for "
                 . $this->request->method->get() . ' '
                 . $this->request->url->get(PHP_URL_PATH) . PHP_EOL . PHP_EOL
                 . 'Params: ' . var_export($this->request->params->get(), true)
                 . PHP_EOL . PHP_EOL
                 . (string) $exception
                 . PHP_EOL;
        $this->response->status->set('500', 'Server Error');
        $this->response->content->set($content);
        $this->response->content->setType('text/plain');
    }
}
