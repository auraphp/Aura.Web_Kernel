<?php
/**
 * Aura\Web_Kernel\WebKernel
 */
$di->params['Aura\Web_Kernel\WebKernel']['responder'] = $di->lazyNew('Aura\Web_Kernel\IntegrationResponder');
