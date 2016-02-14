<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\Node as Model;
use DockerCloud\Test\API\NodeTest as APITest;

class NodeTest extends AbstractModelTest
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
