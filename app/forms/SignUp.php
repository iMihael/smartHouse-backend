<?php

namespace app\forms;

use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email as EmailValidator;

class SignUp extends Form
{
    public function initialize()
    {
        $firstName = new Text('first_name');
        $firstName->addValidator(new PresenceOf([
            'label' => 'First Name'
        ]));
        $this->add($firstName);

        $lastName = new Text('last_name');
        $lastName->addValidator(new PresenceOf([
            'label' => 'Last Name'
        ]));
        $this->add($lastName);

        $email = new Email('email');
        $email->addValidator(new PresenceOf([
            'label' => 'Email'
        ]));
        $email->addValidator(new EmailValidator([
            'label' => 'Email'
        ]));
        $this->add($email);

        $password = new Password('password');
        $password->addValidator(new PresenceOf([
            'label' => 'Password'
        ]));
        $this->add($password);

        $passwordConfirm = new Password('password_confirm');
        $passwordConfirm->addValidator(new PresenceOf([
            'label' => 'Confirm Password'
        ]));
        $passwordConfirm->addValidator(new Confirmation([
            'label' => 'Confirm Password',
            'with' => 'password',
        ]));
        $this->add($passwordConfirm);
    }
}
