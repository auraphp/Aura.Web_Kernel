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
namespace Tarcha\WebKernel\Actions;

use Aura\Web\Request;
use Aura\Web_Kernel\MissingAction as AuraMissingAction;
use Tarcha\WebKernel\Responders\MissingActionResponder;

/**
 *
 * A action for when the web kernel cannot find a action for a route.
 *
 * @package Aura.Web_Kernel
 *
 */
class MissingAction extends AuraMissingAction
{
}
