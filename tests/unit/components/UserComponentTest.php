<?php

namespace tests\unit\components;

use app\components\IdentityInterface;
use app\components\User;
use tests\unit\helpers\FooUser;
use tests\UnitTestCase;

class UserComponentTest extends UnitTestCase
{
    use FooUser;

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

    public function testUserLoginLogout() {
        $user = $this->createFooUser();
        /**
         * @var $auth User
         */
        $auth = $this->di->get('user');

        $this->assertTrue($auth->isGuest());
        $this->assertNull($auth->getIdentity());
        $this->assertNull($auth->getId());

        $auth->login($user);

        $this->assertFalse($auth->isGuest());
        $this->assertInstanceOf(IdentityInterface::class, $auth->getIdentity());
        $this->assertInternalType('string', $auth->getId());

        $auth->logout();

        $this->assertTrue($auth->isGuest());
        $this->assertNull($auth->getIdentity());
        $this->assertNull($auth->getId());

        $user->delete();
    }
}