<?php

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder;

$containerBuilder->addDefinitions(require __DIR__ . '/dependencies.php');
return $containerBuilder->build();
