<?php

namespace app\modules\admin\controllers;

use app\modules\admin\collections\ModuleCategory;
use Phalcon\Mvc\Controller;

class ModuleCategoryController extends Controller {
    public function listAction() {
        //ModuleCategory::softDelete()
        $categories = ModuleCategory::find([
            'sort' => [
                'created_at' => -1
            ],
        ]);

        var_dump($categories);
        die;
    }

    public function createAction() {
        $mc = new ModuleCategory();
        $mc->name = 'foo';
        $mc->description = 'ssss';
        $mc->save();

    }

    public function editAction() {
        if($cat = ModuleCategory::findById('57c16949b2fdeaae2a21dc58')) {
            $cat->name = 'sadwqdqw!';
            $cat->save();
        }
    }

    public function deleteAction() {
        $mc = new ModuleCategory();
        $mc->name = 'foo';
        $mc->description = 'ssss';
        $mc->save();

        $mc->delete();
    }
}