<?php

namespace tests\unit\forms;

use app\components\User;
use app\forms\Login;
use tests\unit\helpers\FooUser;
use tests\UnitTestCase;

class UserLoginFormTest extends UnitTestCase
{
    use FooUser;

    public function testLoginForm()
    {
        $user = $this->createFooUser();

        $form = new Login();
        $this->assertFalse($form->isValid([]));

        $this->assertTrue($form->isValid([
            'email' => 'vasia@gmail.com',
            'password' => '123'
        ]));

        $this->assertFalse($form->loginUser('vasia@gmail.com', '123'));
        $result = $form->loginUser($user->email, $this->userPassword);
        $this->assertTrue($result);

        /**
         * @var $auth User
         */
        $auth = $this->getDI()->get('user');
        $this->assertFalse($auth->isGuest());
    }
}