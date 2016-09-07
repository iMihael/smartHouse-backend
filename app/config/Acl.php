<?php

namespace app\config;

use Phalcon\Acl as PAcl;
use Phalcon\Acl\Adapter\Mongo;

class Acl
{
    const COLLECTION_ACL_ROLES = 'acl_roles';
    const COLLECTION_ACL_RESOURCES = 'acl_resources';
    const COLLECTION_ACL_ACCESSES = 'acl_resources_accesses';
    const COLLECTION_ACL_ACCESS_LIST = 'acl_access_list';

    private $acl;

    public function __construct($databaseName)
    {
        $this->acl = new Mongo([
            'db' => $databaseName,
            'roles' => self::COLLECTION_ACL_ROLES,
            'resources' => self::COLLECTION_ACL_RESOURCES,
            'resourcesAccesses' => self::COLLECTION_ACL_ACCESSES,
            'accessList' => self::COLLECTION_ACL_ACCESS_LIST,
        ]);

        $this->acl->setDefaultAction(PAcl::DENY);
    }

    public function getAcl()
    {
        return $this->acl;
    }
}