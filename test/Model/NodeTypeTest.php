<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\NodeType as Model;
use DockerCloud\Test\API\NodeTypeTest as APITest;

class NodeTypeTest extends AbstractModelTest
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
