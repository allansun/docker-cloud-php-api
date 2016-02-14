<?php


namespace DockerCloud\Test\Model;

use DockerCloud\Model\ServiceTrigger as Model;
use DockerCloud\Test\API\ServiceTriggerTest as APITest;

class ServiceTriggerTest extends AbstractModelTest
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
