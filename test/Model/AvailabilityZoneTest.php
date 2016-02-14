<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\AvailabilityZone as Model;
use DockerCloud\Test\API\AvailabilityZoneTest as APITest;

class AvailabilityZoneTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        return APITest::getMockData();
    }
}
