<?php

namespace app\controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public function __call($name, $arguments)
    {
        //TODO: show 404 error
        $this->response->redirect('index/index');
    }
}