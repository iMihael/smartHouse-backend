<?php

namespace app\components;

use Phalcon\Http\Response\Cookies;

class User
{
    /**
     * @var IdentityInterface
     */
    private $identity;

    /**
     * @var Cookies
     */
    private $cookies;

    private $identityClassName;

    public $idParam = '_identity';

    //errors
    const IS_NOT_IDENTITY = 13;
    const INVALID_IDENTITY = 14;


    public function __construct(Cookies $cookies, $identityClassName)
    {
        $this->cookies = $cookies;

        if(class_exists($identityClassName)) {
            $implements = class_implements($identityClassName);
            if(in_array(IdentityInterface::class, $implements)) {
                $this->identityClassName = $identityClassName;
                return;
            }

        }

        throw new \Exception('Identity class is not implementing interface', self::IS_NOT_IDENTITY);
    }


    public function getIdentity()
    {
        if(!$this->identity) {
            if($id = $this->cookies->get($this->idParam)) {
                if($data = json_decode($id, true)) {
                    if (count($data) == 2) {
                        list($id, $authKey) = $data;

                        /* @var $class IdentityInterface */
                        $class = $this->identityClassName;

                        if ($identity = $class::findIdentity($id)) {
                            if (!$identity instanceof IdentityInterface) {
                                throw new \Exception('Invalid identity', self::INVALID_IDENTITY);
                            } else if (!$identity->validateAuthKey($authKey)) {
                                //TODO: log hack attempt
                            } else {
                                $this->identity = $identity;
                            }
                        }
                    }
                }
            }
        }

        return $this->identity;
    }

    public function getId() {
        if($identity = $this->getIdentity()) {
            return $identity->getIdentityId();
        }

        return null;
    }

    public function isGuest()
    {
        if($this->getIdentity()) {
            return false;
        } else {
            return true;
        }
    }

    public function login(IdentityInterface $identity, $duration = 0)
    {
        $this->identity = $identity;
        $this->cookies->set(
            $this->idParam,
            json_encode([
                $this->identity->getIdentityId(),
                $this->identity->getAuthKey(),
            ]),
            $duration
        );
    }

    public function logout()
    {
        $this->cookies->set($this->idParam, null);
        $this->identity = null;
    }
}