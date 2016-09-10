<?php

namespace tests\phpunit\tests\forms;

use app\forms\SignUp;
use tests\phpunit\UnitTestCase;

class UserSignUpFormTest extends UnitTestCase
{
    public function testSignUpForm()
    {
        $form = new SignUp();
        $this->assertFalse($form->isValid([]));

        $this->assertFalse($form->isValid([
            'first_name' => 'foo',
            'last_name' => 'bar',
            'email' => 'foo',
        ]));

        $this->assertNotEmpty($form->getMessages());

        $this->assertTrue($form->isValid([
            'first_name' => 'foor',
            'last_name' => 'bar',
            'email' => 'vasia@gmail.com',
            'password' => '123',
            'password_confirm' => '123'
        ]));
    }
}
