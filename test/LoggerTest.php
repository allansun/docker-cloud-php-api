<?php


namespace DockerCloud\Test;


use DockerCloud\Logger;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;

/**
 * Class LoggerTest
 *
 * @package DockerCloud\Test
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testProductionEnvironment()
    {
        putenv('DEBUG');
        $this->assertInstanceOf(NullHandler::class, Logger::reInitiate()->getLogger()->getHandlers()[0]);
    }

    public function testDebugEnvironment()
    {
        putenv('DEBUG=true');
        $this->assertInstanceOf(StreamHandler::class, Logger::reInitiate()->getLogger()->getHandlers()[0]);
    }

}
