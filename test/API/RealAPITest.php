<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\AbstractAPI;
use DockerCloud\Exception;

class RealAbstractAPITest extends AbstractAPITest
{
    public function testValidateFilterWithInvalidFilter()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('/.*allowed filter/');
        /** @var AbstractAPI $MockAPI */
        $MockAPI = $this->getMockForAbstractClass(AbstractAPI::class);
        $MockAPI->validateFilter(['test']);
    }

}