<?php

namespace app\config;

use Phalcon\Db\Adapter\MongoDB\Client;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\Collection\Manager as CollectionManager;

class Services {

    /**
     * @var FactoryDefault
     */
    private $di;

    public function __construct() {
        $this->di = new FactoryDefault();

        $this->di->set('mongo', function(){
            $mongo = new Client();
            return $mongo->selectDatabase('smart_house');
        }, true);

        $this->di->set('collectionManager', function(){
            return new CollectionManager();
        }, true);

        $this->di->set(
            'voltService',
            function ($view, $di) {

                $volt = new Volt($view, $di);

                $volt->setOptions(
                    [
                        'compiledPath'      => '../app/cache/volt/',
                        'compiledExtension' => '.compiled',
                        'compileAlways' => true, //TODO: on production fix
                        'autoescape' => true,
                    ]
                );

                return $volt;
            }
        );

        $this->di->set('view', function(){

            $view = new View();
            $view->setViewsDir('../app/views/');
            $view->registerEngines(
                [
                    '.volt' => 'voltService'
                ]
            );
            return $view;
        });

        $this->di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("app\\controllers");
            return $dispatcher;
        });


        $this->di->set('router', function(){
            $router = new Router();
            return $router->getRouter();
        });

        $this->di->set('url', function () {
            $url = new Url();
            $url->setBaseUri('/');
            return $url;
        });

    }

    public function getDI() {
        return $this->di;
    }
}