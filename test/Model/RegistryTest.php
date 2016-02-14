<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Registry as Model;
use DockerCloud\Test\API\RegistryTest as APITest;

class RegistryTest extends AbstractModelTest
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
