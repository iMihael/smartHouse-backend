<?php

namespace console;

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Mongo;

include "../vendor/autoload.php";
$params = include '../app/config/params.php';

$acl = new Mongo([
    'db' => $params['mongo']['databaseName'],
    'roles' => 'acl_roles',
    'resources' => 'acl_resources',
    'resourcesAccesses' => 'acl_resources_accesses',
    'accessList' => 'acl_access_list',
]);

$acl->setDefaultAction(Acl::DENY);

$acl->addRole('admin');
$acl->addRole('user');

$acl->addResource(new Acl\Resource('auth'), ['login', 'signup']);






$acl->addRole(new Acl\Role('user'));

