<?php

namespace Tarcha\WebKernel\Filters;

use Aura\Filter\RuleCollection;
use Aura\Filter\RuleLocator;

class Rules extends RuleCollection
{
    public function __construct(RuleLocator $locator)
    {
         parent::__construct($locator);
         
         addCustomRules();
    }
    
    public function addCustomRules()
    {
        //TO ADD IF NEEDED
    }
    
    public function unsetRules()
    {
        $this->rules = [];
    }
}