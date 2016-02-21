<?php


namespace DockerCloud\Test\Model\Response;


use DockerCloud\Exception;
use DockerCloud\Model\Response\AbstractResponse;
use DockerCloud\Test\API\AbstractAPITest;

class RealAbstractResponseTest extends AbstractAPITest
{
    public function testConstructWithObject()
    {
        $stub = json_decode('{"id":1}');
        /** @var AbstractResponse $MockAPI */
        $MockAPI = $this->getMockForAbstractClass(AbstractResponse::class, [
            $stub
        ]);

        $this->assertEquals($stub, $MockAPI->getResponse());
    }

    public function testConstructWithString()
    {
        $stub = '{"id":1}';
        /** @var AbstractResponse $MockAPI */
        $MockAPI = $this->getMockForAbstractClass(AbstractResponse::class, [
            $stub
        ]);

        $this->assertEquals(1, $MockAPI->getResponse()->id);
    }

    public function testConstructWithUnknown()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unknown Response');
        $stub = [];
        /** @var AbstractResponse $MockAPI */
        $MockAPI = $this->getMockForAbstractClass(AbstractResponse::class, [
            $stub
        ]);
    }
}