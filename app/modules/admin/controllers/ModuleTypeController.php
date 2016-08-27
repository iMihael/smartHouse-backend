<?php

namespace app\modules\admin\controllers;

use app\modules\admin\collections\ModuleType;
use Phalcon\Mvc\Controller;

class ModuleTypeController extends Controller {
    public function listAction() {
        //ModuleType::softDelete()
        $categories = ModuleType::find([
            'sort' => [
                'created_at' => -1
            ],
        ]);

        var_dump($categories);
        die;
    }

    public function createAction() {
        $mc = new ModuleType();
        $mc->name = 'foo';
        $mc->description = 'ssss';
        $mc->save();

    }

    public function editAction() {
        if($cat = ModuleType::findById('57c16949b2fdeaae2a21dc58')) {
            $cat->name = 'sadwqdqw!';
            $cat->save();
        }
    }

    public function deleteAction() {
        $mc = new ModuleType();
        $mc->name = 'foo';
        $mc->description = 'ssss';
        $mc->save();

        $mc->delete();
    }
}