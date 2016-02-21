<?php


namespace DockerCloud\Test;


use DockerCloud\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class LoggerTest
 *
 * @package DockerCloud\Test
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{
    static $originalDebugMode = false;

    static public function setUpBeforeClass()
    {
        static::$originalDebugMode = getenv('DEBUG');
    }

    static public function tearDownAfterClass()
    {
        putenv('DEBUG=' . static::$originalDebugMode);
    }

    public function testProductionEnvironment()
    {
        putenv('DEBUG');
        $this->assertInstanceOf(StreamHandler::class, Logger::reInitiate()->getLogger()->getHandlers()[0]);
        Logger::getInstance()->debug('Test from testProductionEnvironment');
    }

    public function testDebugEnvironment()
    {
        putenv('DEBUG=true');
        $this->assertInstanceOf(StreamHandler::class, Logger::reInitiate()->getLogger()->getHandlers()[0]);
        Logger::getInstance()->debug('Test from testDebugEnvironment');
    }

    public function testSetLogger()
    {
        Logger::getInstance()->setLogger(new \Monolog\Logger('UnitTest'));
        Logger::getInstance()->debug('Test from testSetLogger()');
        $this->assertInstanceOf(\Psr\Log\LoggerInterface::class, Logger::getInstance()->getLogger());
    }
}
