<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Action as Model;
use DockerCloud\Test\API\ActionTest as APITest;

class ActionTest extends AbstractModelTest
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
