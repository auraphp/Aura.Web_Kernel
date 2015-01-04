<?php

namespace Tarcha\WebKernel\Filters;

use Aura\Filter\FilterFactory;

class AbstractFilter
{
    public function __construct(FilterFactory $factory)
    {
        $this->factory = $factory;
        $this->filter = $factory->newInstance();
    }
    
    public function addId($field)
    {
        $this->filter
            ->validate($field)
            ->is('int')
            ->asSoftRule();
            
        $this->filter
            ->validate($field)
            ->isNot('max', 0)
            ->asSoftRule();
    }
    
    public function addBlank($field)
    {
        $this->filter
            ->validate($field)
            ->is('blank')
            ->asSoftRule();
    }
    
    public function addString($field)
    {
        $this->filter
            ->validate($field)
            ->is('alpha')
            ->asSoftRule();
    }
    
    public function addInt($field)
    {
        $this->filter
            ->validate($field)
            ->is('int')
            ->asSoftRule();
    }
    
    public function addFloat($field)
    {
        $this->filter
            ->validate($field)
            ->is('float')
            ->asSoftRule();
    }
    
    public function addTime($field)
    {
        $this->filter
            ->validate($field)
            ->is('int')
            ->asSoftRule();
            
        $this->filter
            ->validate($field)
            ->isNot('max', 0)
            ->asSoftRule();
    }
    
    public function validate($values)
    {
        return $this->filter->apply($values);
    }
    
    public function newFilter()
    {
        $this->filter = $this->factory->newInstance();
        return $this->filter;
    }
}