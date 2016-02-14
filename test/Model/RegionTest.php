<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Region as Model;
use DockerCloud\Test\API\RegionTest as APITest;

class RegionTest extends AbstractModelTest
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
