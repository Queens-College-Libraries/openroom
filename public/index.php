<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/vendor/autoload.php';
$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    \model\HelloWorld::class => \DI\create(\model\HelloWorld::class)
]);

$container = $containerBuilder->build();

$helloWorld = $container->get(\model\HelloWorld::class);
$helloWorld->sayBye();