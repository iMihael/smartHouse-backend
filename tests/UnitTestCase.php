<?php

namespace tests;

use app\config\Services;
use Phalcon\Db\Adapter\MongoDB\Client;
use Phalcon\Di;
use Phalcon\Test\UnitTestCase as PhalconTestCase;
use Phalcon\Mvc\Collection\Manager as CollectionManager;

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

        $this->setDI($di);

        $this->_loaded = true;
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