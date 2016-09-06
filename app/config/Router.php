<?php

namespace app\config;

use Phalcon\Mvc\Router as PhalconRouter;

class Router {

    /**
     * @var PhalconRouter
     */
    private $router;

    const DEFAULT_NAMESPACE = 'app\controllers';
    const ADMIN_NAMESPACE = 'app\modules\admin\controllers';

    public function __construct() {
        $this->router = new PhalconRouter(false);
        $this->router->setUriSource(PhalconRouter::URI_SOURCE_SERVER_REQUEST_URI);

        $this->router->add('/', [
            'namespace' => self::DEFAULT_NAMESPACE,
            'controller' => 'index',
            'action' => 'index',
        ]);

        $this->router->add('/:controller/:action/:params', [
            'controller' => 1,
            'action' => 2,
            'params' => 3,
            'namespace' => self::DEFAULT_NAMESPACE,
        ]);

        $this->router->notFound([
            'namespace' => self::DEFAULT_NAMESPACE,
            'controller' => 'index',
            'action' => 'route404'
        ]);

        $this->router->add(
            '/admin/:controller/:action/:params',
            [
                'module'     => 'admin',
                'controller' => 1,
                'action'     => 2,
                'params'     => 3,
                'namespace' => self::ADMIN_NAMESPACE,
            ]
        );
    }

    public function getRouter() {
        return $this->router;
    }
}