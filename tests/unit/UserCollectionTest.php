<?php

namespace tests\unit;

use app\collections\User;
use app\components\IdentityInterface;
use Phalcon\Security\Random;
use tests\UnitTestCase;

class UserCollectionTest extends UnitTestCase
{
    public function testCreateUser()
    {
        $user = new User();
        if($user->save()) {
            $this->fail();
        } else {
            $messages = $user->getMessages();
            $this->assertNotEmpty($messages);
        }

        $user = new User();
        $user->first_name = 'Mike';
        $user->last_name = 'B.';
        $user->email = 'mike@gmail.com';
        $user->setPassword('123456');
        $user->generateAuthKey();

        if($user->save()) {
            $id = $user->getId();
            $this->assertInstanceOf(\MongoDB\BSON\ObjectID::class, $id);
        }

        $user->email = 'foo';
        if($user->save()) {
            $this->fail();
        } else {
            $this->assertNotEmpty($user->getMessages());
        }
    }

    public function testUserIdentityInterface()
    {
        $user = new User();
        $user->first_name = 'Mike';
        $user->last_name = 'B.';
        $user->email = 'mike@gmail.com';
        $user->setPassword('123456');
        $user->generateAuthKey();

        if($user->save()) {

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
            $user->save();

            $identityUser = User::findIdentityByAccessToken($token);
            $this->assertInstanceOf(IdentityInterface::class, $identityUser);

            $identityUser = User::findIdentityByAccessToken('123');
            $this->assertEquals(null, $identityUser);

            $authKey = $user->getAuthKey();
            $this->assertInternalType('string', $authKey);

            $this->assertTrue($user->validateAuthKey($authKey));

        } else {
            $this->fail();
        }
    }
}