<?php


namespace DockerCloud\Test\Model;


use DockerCloud\Model\NodeCluster as Model;
use DockerCloud\Test\API\NodeClusterTest as APITest;

class NodeClusterTest extends AbstractModelTest
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
