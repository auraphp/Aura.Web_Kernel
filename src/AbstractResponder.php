<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\Web_Kernel;

use Aura\Web\Response;

/**
 *
 * An abstract web kernel action.
 *
 * You should probably *not* extend this for your own actions. Create your
 * own base action so that you can avoid a dependency on this package.
 *
 * @package Aura.Web_Kernel
 *
 */
abstract class AbstractResponder
{
    /**
     *
     * Data for building the response.
     *
     * @var array
     *
     */
    protected $data;

    /**
     *
     * A web response object.
     *
     * @var Response
     *
     */
    protected $response;

    /**
     *
     * Constructor.
     *
     * @param Response $response A web response object.
     *
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     *
     * Sets data for building the response.
     *
     * @param array $data Data for the response.
     *
     * @return null
     *
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     *
     * Invokes the responder.
     *
     * @return null
     *
     */
    abstract public function __invoke();

    /**
     *
     * Exports the params in an easier-to-read format, especially for objects.
     *
     * @param array $params
     *
     */
    protected function exportParams($params)
    {
        if (! $params) {
            return 'none';
        }

        $export = array();
        foreach ($params as $key => $val) {
            $key = var_export($key, true);
            if (is_object($val)) {
                $export[] = "    {$key} => " . get_class($val);
            } else {
                $export[] = "    {$key} => " . var_export($val, true);
            }
        }
        return 'array (' . PHP_EOL . implode(PHP_EOL, $export) . PHP_EOL . ')';
    }
}
