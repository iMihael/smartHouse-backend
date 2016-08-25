<?php

namespace app\modules\admin;

use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
//use Phalcon\Mvc\View\Simple as View;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {

    }

    public function registerServices(DiInterface $di)
    {
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir('../app/modules/admin/views/');
            $view->registerEngines(
                [
                    '.volt' => 'voltService'
                ]
            );
            $view->disableLevel([
                View::LEVEL_LAYOUT => true,
                VIEW::LEVEL_MAIN_LAYOUT => true,
            ]);
            return $view;
        });
    }
}