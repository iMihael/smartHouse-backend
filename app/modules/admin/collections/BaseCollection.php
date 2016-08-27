<?php

namespace app\modules\admin\collections;

use Phalcon\Mvc\CollectionInterface;
use Phalcon\Mvc\MongoCollection as Collection;
use Phalcon\Mvc\Collection\Behavior\Timestampable;
use Phalcon\Mvc\Collection\Behavior\SoftDelete;

class BaseCollection extends Collection {

    const WITH_DELETED_ATTR = 'withDeleted';

    protected static function softDelete() {
        return true;
    }

    public function initialize() {
        $this->addBehavior(new Timestampable([
            'beforeCreate' => [
                'field' => 'created_at',
                'generator' => function () {
                    return new \MongoDB\BSON\UTCDateTime(time());
                }
            ],
            'beforeUpdate' => [
                'field' => 'updated_at',
                'generator' => function () {
                    return new \MongoDB\BSON\UTCDateTime(time());
                }
            ],
        ]));

        if(static::softDelete()) {
            $this->addBehavior(new SoftDelete([
                'field' => 'deleted_at',
                'value' => new \MongoDB\BSON\UTCDateTime(time()),
            ]));
        }

    }

    public static function findWithDeleted($params) {
        $params[self::WITH_DELETED_ATTR] = true;
        return self::find($params);
    }

    protected static function _getResultset($params, CollectionInterface $collection, $connection, $unique)
    {
        if((!isset($params[self::WITH_DELETED_ATTR]) || !$params[self::WITH_DELETED_ATTR]) && static::softDelete()) {
            $index = isset($params['conditions']) ? 'conditions' : 0;
            $params[$index]['deleted_at'] = ['$exists' => false,];
        }

        return parent::_getResultset($params, $collection, $connection, $unique); // TODO: Change the autogenerated stub
    }
}