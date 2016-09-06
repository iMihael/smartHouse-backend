<?php

namespace tests\unit\helpers;

use app\collections\User;

trait FooUser {
    public function createFooUser() {
        $user = new User();
        $user->first_name = 'Mike';
        $user->last_name = 'B.';
        $user->email = 'mike@gmail.com';
        $user->setPassword('123456');
        $user->generateAuthKey();

        if($user->save()) {
            return $user;
        } else {
            throw new \Exception('User creation error');
        }
    }
}