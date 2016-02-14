<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Provider as Model;
use DockerCloud\Test\API\ProviderTest as APITest;

class ProviderTest extends AbstractModelTest
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
