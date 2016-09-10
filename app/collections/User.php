<?php

namespace app\collections;

use app\components\IdentityInterface;
use app\config\Acl;
use app\modules\admin\collections\BaseCollection;
use app\validators\IsUnique;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Security;

/**
 * Class User
 * @property string $password_hash
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property string $email
 * @package app\collections
 */
class User extends BaseCollection implements IdentityInterface
{
    public function initialize()
    {
        $this->role = Acl::ROLE_USER;
    }

    public function getIdentityId()
    {
        return (string)$this->getId();
    }

    public function getRole()
    {
        if ($this->role) {
            return $this->role;
        }

        return Acl::ROLE_USER;
    }

    public static function findIdentity($id)
    {
        return self::findById($id);
    }

    public static function findIdentityByAccessToken($token)
    {
        return self::findFirst([
            [
                'access_tokens' => $token
            ]
        ]);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    public function setPassword($plainPassword)
    {
        /**
         * @var $security Security
         */
        $security = $this->getDI()->get('security');
        $this->password_hash = $security->hash($plainPassword);
    }

    public function generateAuthKey()
    {
        $random = new Security\Random();
        $this->auth_key = $random->base64Safe(32);
    }

    public function attributeNames()
    {
        return [
            'first_name',
            'last_name',
            'email',
            'role',
        ];
    }

    public function validation()
    {
        $presence = [
            'first_name',
            'last_name',
            'email',
            'password_hash',
            'auth_key',
            'role'
        ];

        foreach ($presence as $field) {
            $this->validate(new PresenceOf([
                'field' => $field,
            ]));
        }

        $this->validate(new Email([
            'field' => 'email',
        ]));

        if (!$this->getId()) {
            $this->validate(new IsUnique([
                'field' => 'email'
            ]));
        }

        return $this->validationHasFailed() != true;
    }

    public function signUp(array $validPost)
    {
        $this->setAttributes($validPost);
        $this->setPassword($validPost['password']);
        $this->generateAuthKey();
        if ($this->save()) {
            /**
             * @var $auth \app\components\User
             */
            $auth = $this->getDI()->get('user');
            $auth->login($this);
            return true;
        } else {
            return false;
        }
    }
}