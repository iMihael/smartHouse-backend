<?php

namespace tests\unit;

use app\components\User;
use tests\UnitTestCase;

class UserComponentTest extends UnitTestCase
{
    public function testUserComponentBuild()
    {
        $cookies = $this->getDI()->get('cookies');
        try {
            $user = new User($cookies, \DateTime::class);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals(User::IS_NOT_IDENTITY, $e->getCode());
        }

        try {
            $user = new User($cookies, \app\collections\User::class);
            $this->assertInstanceOf(User::class, $user);
        } catch (\Exception $e) {
            $this->fail();
        }
    }
}