<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Container as Model;
use DockerCloud\Test\API\ContainerTest as APITest;

class ContainerTest extends AbstractModelTest
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
