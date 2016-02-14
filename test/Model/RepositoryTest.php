<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Repository as Model;
use DockerCloud\Test\API\RepositoryTest as APITest;

class RepositoryTest extends AbstractModelTest
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
