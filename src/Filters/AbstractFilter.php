<?php

namespace Tarcha\WebKernel\Filters;

use Aura\Filter\RuleCollection;
use Aura\Filter\RuleLocator;

class AbstractFilter extends RuleCollection
{
    private $data;

    public function id($field, $val)
    {
        $this
            ->addSoftRule($field, self::IS, 'int')
            ->addSoftRule($field, self::IS_NOT, 'max', 0);

        $this->data[$field] = $val;
    }

    public function string($field, $val)
    {
        $this->addSoftRule($field, self::IS, 'alpha');

        $this->data[$field] = $val;
    }

    public function int($field, $val)
    {
        $this->addSoftRule($field, self::IS, 'int');

        $this->data[$field] = $val;
    }

    public function time($field, $val)
    {
        $this
            ->addSoftRule($field, self::IS, 'number')
            ->addSoftRule($field, self::IS_NOT, 'max', 0);

        $this->addData($field, $val);
    }

    public function addData($field, $val)
    {
        $this->data[$field] = $val;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getValues()
    {
        return $this->values($this->data);
    }
}
