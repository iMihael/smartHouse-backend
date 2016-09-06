<?php

namespace app\forms;

use app\collections\User;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Form;
use Phalcon\Security;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Login extends Form
{
    public function initialize()
    {
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

        $stayIn = new Check('stayIn');
        $this->add($stayIn);
    }

    public function loginUser($email, $password, $stayIn = false) {
        if($user = User::findFirst([['email' => $email]])) {
            /**
             * @var $security Security
             */
            $security = $this->getDI()->get('security');
            if($security->checkHash($password, $user->password_hash)) {

                /**
                 * @var $auth \app\components\User
                 */
                $auth = $this->getDI()->get('user');
                $duration = 0;

                if($stayIn) {
                    $duration = time() + 31536000;
                }

                $auth->login($user, $duration);

                return true;
            }
        }

        return false;
    }
}
