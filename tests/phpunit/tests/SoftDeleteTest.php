<?php

namespace tests\phpunit\tests;

use app\modules\admin\collections\BaseCollection;
use tests\phpunit\UnitTestCase;


class SoftDeletableCollection extends BaseCollection
{
    public function getSource()
    {
        return "soft_deletable_collection";
    }
}

class NonSoftDeletableCollection extends BaseCollection
{
    protected static function softDelete()
    {
        return false;
    }

    public function getSource()
    {
        return "non_soft_deletable_collection";
    }
}

class SoftDeleteTest extends UnitTestCase
{
    public function testCanNotBeDeleted()
    {
        $sdc = new SoftDeletableCollection();
        $sdc->name = 'sss';
        $sdc->description = 'asdawqd';
        $sdc->save();

        $id = $sdc->getId();

        $sdc->delete();

        $sdc = SoftDeletableCollection::findById($id);

        $this->assertEquals(null, $sdc);

        $sdc = SoftDeletableCollection::findWithDeleted([
            ['_id' => $id]
        ]);

        if (isset($sdc[0])) {
            $this->assertInstanceOf(SoftDeletableCollection::class, $sdc[0]);
        }
    }

    public function testCanBeDeleted()
    {
        $nsdc = new NonSoftDeletableCollection();
        $nsdc->name = 'sss';
        $nsdc->description = 'asdawqd';
        $nsdc->save();

        $id = $nsdc->getId();

        $nsdc->delete();

        $nsdc = SoftDeletableCollection::findById($id);

        $this->assertEquals(null, $nsdc);

        $nsdc = SoftDeletableCollection::findWithDeleted([
            ['_id' => $id]
        ]);

        $this->assertEquals([], $nsdc);
    }
}