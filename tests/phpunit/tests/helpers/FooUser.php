<?php

namespace tests\phpunit\tests\helpers;

use app\collections\User;
use app\config\Acl;

trait FooUser {

    private $userPassword = '123456';

    public function createFooUser() {
        $user = new User();
        $user->first_name = 'Mike';
        $user->last_name = 'B.';
        $user->email = 'mike@gmail.com';
        $user->role = Acl::ROLE_USER;
        $user->setPassword($this->userPassword);
        $user->generateAuthKey();

        if($user->save()) {
            return $user;
        } else {
            throw new \Exception('User creation error');
        }
    }
}