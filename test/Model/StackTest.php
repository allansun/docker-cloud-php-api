<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Stack as Model;
use DockerCloud\Test\API\StackTest as APITest;

class StackTest extends AbstractModelTest
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
