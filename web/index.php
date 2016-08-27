<?php

namespace app\web;

include "../vendor/autoload.php";

use app\config\Services;
use Phalcon\Loader;
use Phalcon\Mvc\Application;

$loader = new Loader();
$loader->registerNamespaces([
    'app' => '../app',
])->register();

$services = new Services();
$app = new Application($services->getDI());
$app->registerModules([
    'admin' => [
        'className' => 'app\modules\admin\Module',
        'path' => '../app/modules/admin/Module.php',
    ],
]);
$app->handle()->send();