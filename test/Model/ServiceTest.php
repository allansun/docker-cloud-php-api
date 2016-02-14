<?php


namespace DockerCloud\Test\Model;

use DockerCloud\Model\Service as Model;
use DockerCloud\Test\API\ServiceTest as APITest;

class ServiceTest extends AbstractModelTest
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
