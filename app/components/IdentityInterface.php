<?php

namespace app\components;

interface IdentityInterface {
    public function getIdentityId();
    public static function findIdentity($id);
    public static function findIdentityByAccessToken($token);
    public function getAuthKey();
    public function validateAuthKey($authKey);
}