<?php

$settings = require 'app/config/settings.php';

use Pimple\Psr11\Container;
use Pimple\Container as PimpleContainer;

use IntecPhp\Model\ContainerDIModelExample;
use IntecPhp\Controller\ContainerDIControllerExample;

$dependencies = new PimpleContainer();
$dependencies['settings'] = $settings;

// ----------------------------------------- Exemplo de injeção de dependência
$dependencies[ContainerDIModelExample::class] = function($c) {
    $param = $c['settings']['di-test'];
    return new ContainerDIModelExample($param);
};

$dependencies[ContainerDIControllerExample::class] = function($c) {
    $cdie = $c[ContainerDIModelExample::class];
    return new ContainerDIControllerExample($cdie);
};
// ----------------------------------------- Exemplo de injeção de dependência


$container = new Container($dependencies);
