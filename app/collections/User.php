<?php

namespace app\collections;

use app\components\IdentityInterface;
use app\modules\admin\collections\BaseCollection;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Security;

/**
 * Class User
 * @property string $password_hash
 * @package app\collections
 */
class User extends BaseCollection implements IdentityInterface
{
    public function getIdentityId() {
        return (string)$this->getId();
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

    public function validation()
    {
        $presence = [
            'first_name',
            'last_name',
            'email',
            'password_hash',
            'auth_key'
        ];

        foreach ($presence as $field) {
            $this->validate(new PresenceOf([
                'field' => $field,
            ]));
        }

        $this->validate(new Email([
            'field' => 'email',
        ]));

        return $this->validationHasFailed() != true;
    }
}