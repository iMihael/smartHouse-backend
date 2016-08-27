<?php

namespace app\modules\admin\collections;

use Phalcon\Mvc\Model\Validator\PresenceOf;

class ModuleCategory extends BaseCollection {
    public function getSource()
    {
        return "module_category";
    }

    public function validation()
    {
        $this->validate(new PresenceOf([
            'field' => 'name',
        ]));

        $this->validate(new PresenceOf([
            'field' => 'description'
        ]));

        return $this->validationHasFailed() != true;
    }
}