<?php

namespace app\validators;

use app\modules\admin\collections\BaseCollection;
use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\ValidatorInterface;

class IsUnique extends Validator implements ValidatorInterface
{
    public function validate(\Phalcon\Mvc\EntityInterface $record)
    {
        $field = $this->getOption('field', false);

        if(!$field) {
            throw new \Exception('Field option is required');
        }

        if(!property_exists($record, $field)) {
            $this->appendMessage('Field' . $field . 'is not set', $field);
            return false;
        }

        if($record instanceof BaseCollection) {
            /**
             * @var $className BaseCollection
             */
            $className = get_class($record);

            if($className::findFirst([
                [$field => $record->$field]
            ])) {
                $this->appendMessage('Field' . $field . 'must be unique in system', $field);
                return false;
            }

            return true;
        } else {
            throw new \Exception('Record is not a BaseCollection');
        }
    }
}