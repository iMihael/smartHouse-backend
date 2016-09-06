<?php

namespace tests\unit\validators;

use app\modules\admin\collections\BaseCollection;
use app\validators\IsUnique;
use tests\UnitTestCase;

class IsUniqueTest extends UnitTestCase
{
    public function testUniqueValidator()
    {
        $nickname = 'blob';

        $t = new TestCollection();
        $t->setAttributes([
            'nickname' => $nickname
        ]);
        $this->assertTrue($t->save());

        $t = new TestCollection();
        $t->setAttributes([
            'nickname' => $nickname
        ]);
        $this->assertFalse($t->save());
    }
}

class TestCollection extends BaseCollection
{
    public function attributeNames()
    {
        return [
            'nickname'
        ];
    }

    public function validation()
    {
        $this->validate(new IsUnique([
            'field' => 'nickname'
        ]));

        return $this->validationHasFailed() != true;
    }
}