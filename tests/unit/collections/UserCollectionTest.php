<?php

namespace tests\unit\collections;

use app\collections\User;
use app\components\IdentityInterface;
use Phalcon\Security\Random;
use tests\unit\helpers\FooUser;
use tests\UnitTestCase;

class UserCollectionTest extends UnitTestCase
{
    use FooUser;

    public function testCreateUser()
    {
        $user = new User();
        if($user->save()) {
            $this->fail();
        } else {
            $messages = $user->getMessages();
            $this->assertNotEmpty($messages);
        }

        $user = $this->createFooUser();

        $id = $user->getId();
        $this->assertInstanceOf(\MongoDB\BSON\ObjectID::class, $id);

        $user->email = 'foo';

        if($user->save()) {
            $this->fail();
        } else {
            $this->assertNotEmpty($user->getMessages());
        }

        $user->delete();
    }

    public function testUserIdentityInterface()
    {
        $user = $this->createFooUser();

        $userId = (string)$user->getId();

        $identityUser = User::findIdentity($userId);
        $this->assertInstanceOf(IdentityInterface::class, $identityUser);

        $rand = new Random();
        $token = $rand->base64Safe(32);
        $user->access_tokens = [
            $token,
            'foo',
            'bar'
        ];
        $this->assertTrue($user->save());

        $identityUser = User::findIdentityByAccessToken($token);
        $this->assertInstanceOf(IdentityInterface::class, $identityUser);

        $identityUser = User::findIdentityByAccessToken('123');
        $this->assertEquals(null, $identityUser);

        $authKey = $user->getAuthKey();
        $this->assertInternalType('string', $authKey);

        $this->assertTrue($user->validateAuthKey($authKey));

        $user->delete();
    }

    public function testUserSignUp()
    {
        $user = new User();
        $result = $user->signUp([
            'first_name' => 'Vasiliy',
            'last_name' => 'Pupkin',
            'email' => 'vasiliy@gmail.com',
            'password' => '123',
        ]);
        $this->assertTrue($result);

        $this->assertFalse($this->getDI()->get('user')->isGuest());
    }
}