<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return
    [
        App\Services\DispatchService\DispatchInterface::class => DI\factory([\App\Container\Factory\DispatchFactory::class, 'create']),
        PDO::class => DI\factory([\App\Container\Factory\DataBaseFactory::class, 'create']),
        Environment::class => function () {
            $loader = new FilesystemLoader(__DIR__ . '/../app/Views');
            return new Environment($loader);
        },
    ];
