<?php

namespace tests\phpunit;

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

include __DIR__ . "/../../vendor/autoload.php";

$loader = new Loader();
$loader->registerNamespaces([
    'app' => __DIR__ . '/../../app',
    'tests' => __DIR__ . '/../',
])->register();

$di = new FactoryDefault();



Di::reset();

// Add any needed services to the DI here

Di::setDefault($di);