<?php

namespace Tarcha\WebKernel\Filters;

use Tarcha\WebKernel\Filters\Rules;

class AbstractFilter
{
    protected $rules;

    public function __construct(Rules $rules)
    {
        $this->rules = $rules;
    }

    public function id($field, $val)
    {
        $this->rules->unsetRules();

        $this->rules->addStopRule($field, $valid::IS, 'int')
            ->addStopRule($field, $valid::IS_NOT, 'max', 0);

        $data = [$field => $val];
        $success = $rules->values($data);
        return $success;
    }

    public function string($field, $val)
    {
        $this->rules->unsetRules();

        $this->rules->addStopRule($item, $valid::IS, 'alpha');

        $data = [$field => $val];
        $success = $rules->values($data);
        return $success;
    }

    public function int($field, $val)
    {
        $this->rules->unsetRules();

        $this->rules->addStopRule($field, $valid::IS, 'int');

        $data = [$field => $val];
        $success = $rules->values($data);
        return $success;
    }

    public function time($field, $val)
    {
        $this->rules->unsetRules();

        $this->rules->addStopRule($item, $valid::IS, 'number')
            ->addStopRule($item, $valid::IS_NOT, 'max', 0);

        $data = [$field => $val];
        $success = $rules->values($data);
        return $success;
    }
}
