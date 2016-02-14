<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Event as Model;
use DockerCloud\Test\API\EventTest as APITest;

class EventTest extends AbstractModelTest
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
