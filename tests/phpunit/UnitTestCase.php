<?php

namespace tests\phpunit;

use app\config\Services;
use Phalcon\Db\Adapter\MongoDB\Client;
use Phalcon\Di;
use Phalcon\Test\UnitTestCase as PhalconTestCase;
use Phalcon\Db\Adapter\MongoDB\Database;
use tests\phpunit\tests\fakes\Response;

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

        $services = new Services($di);

        $di->set('mongo', function(){
            $mongo = new Client();
            return $mongo->selectDatabase('smart_house_test');
        }, true);

        $di->set('response', function(){
            return new Response();
        });

        $this->setDI($services->getDI());

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