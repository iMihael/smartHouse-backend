<?php

namespace app\config;

use app\components\User;
use Phalcon\Crypt;
use Phalcon\Db\Adapter\MongoDB\Client;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\Collection\Manager as CollectionManager;
use Phalcon\Security;
use Phalcon\Session\Adapter\Files as Session;

class Services {

    /**
     * @var FactoryDefault
     */
    private $di;

    public function __construct($di = false) {
        if(!$di) {
            $this->di = new FactoryDefault();
        } else {
            $this->di = $di;
        }

        $params = include(__DIR__ . '/params.php');

        $this->di->set('mongo', function() use ($params){
            $mongo = new Client($params['mongo']['uri']);
            return $mongo->selectDatabase($params['mongo']['databaseName']);
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

                $compiler = $volt->getCompiler();
                $compiler->addFunction('isGuest', function() {
                    return '$this->di->get("user")->isGuest()';
                });

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

        $this->di->set('crypt', function () use ($params) {
            $crypt = new Crypt();

            $crypt->setKey($params['security']['cryptKey']);

            return $crypt;
        });

        $this->di->set('security', function () {

            $security = new Security();

            // Set the password hashing factor to 12 rounds
            $security->setWorkFactor(12);

            return $security;
        }, true);

        $this->di->set('cookies', function () {
            $cookies = new Cookies();
            return $cookies;
        });

        $this->di->set('session', function(){
            $s = new Session();
            $s->start();
            return $s;
        });

        $di = $this->di;

        $this->di->set('user', function() use ($di){
            $cookies = $di->get('cookies');
            $user = new User($cookies, \app\collections\User::class);
            return $user;
        });

        //TODO: think about caching (serialize) di as object
    }

    public function getDI() {
        return $this->di;
    }
}