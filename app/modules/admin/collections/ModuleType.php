<?php

namespace app\modules\admin\collections;

use Phalcon\Mvc\Model\Validator\PresenceOf;

class ModuleType extends BaseCollection {

    public static function softDelete() {
        return false;
    }

    public function getSource()
    {
        return "module_type";
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