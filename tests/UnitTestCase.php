<?php

namespace tests;

use app\config\Services;
use Phalcon\Db\Adapter\MongoDB\Client;
use Phalcon\Di;
use Phalcon\Http\Response\Cookies;
use Phalcon\Security;
use Phalcon\Test\UnitTestCase as PhalconTestCase;
use Phalcon\Mvc\Collection\Manager as CollectionManager;
use Phalcon\Db\Adapter\MongoDB\Database;

abstract class UnitTestCase extends PhalconTestCase
{
    /**
     * @var \Voice\Cache
     */
    protected $_cache;

    /**
     * @var \Phalcon\Config
     */
    protected $_config;

    /**
     * @var bool
     */
    private $_loaded = false;

    public function setUp()
    {
        parent::setUp();

        // Load any additional services that might be required during testing
        $di = Di::getDefault();

        $di->set('collectionManager', function(){
            return new CollectionManager();
        }, true);

        $di->set('mongo', function(){
            $mongo = new Client();
            return $mongo->selectDatabase('smart_house_test');
        }, true);

        $di->set('cookies', function () {
            $cookies = new Cookies();
            return $cookies;
        });

        $di->set('security', function () {

            $security = new Security();

            // Set the password hashing factor to 12 rounds
            $security->setWorkFactor(12);

            return $security;
        }, true);

        $this->setDI($di);

        $this->_loaded = true;
    }

    protected function tearDown()
    {
        /**
         * @var $mongo Database;
         */
        $mongo = $this->getDI()->get('mongo');
        $mongo->drop();
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
        }
    }
}