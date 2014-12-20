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
namespace Tarcha\WebKernel\Responders;

use Exception;

/**
 *
 * A action for when the web kernel catches an exception.
 *
 * @package Aura.Web_Kernel
 *
 */
class CaughtExceptionResponder extends AbstractResponder
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
        $this->response->status->set('500', 'Server Error');
        $this->response->content->setType('text/plain');
    }
}
