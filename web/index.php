<?php

namespace web;

include __DIR__ . "/../vendor/autoload.php";

use app\config\Services;
use Phalcon\Loader;
use Phalcon\Mvc\Application;

$loader = new Loader();
$loader->registerNamespaces([
    'app' => __DIR__ . '/../app',
])->register();

$services = new Services();
$app = new Application($services->getDI());
$app->registerModules([
    'admin' => [
        'className' => 'app\modules\admin\Module',
        'path' => __DIR__ . '/../app/modules/admin/Module.php',
    ],
]);
$app->handle()->send();
