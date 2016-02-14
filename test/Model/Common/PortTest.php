<?php


namespace DockerCloud\Test\Model\Common;


use DockerCloud\Model\Common\Port as Model;
use DockerCloud\Model\Container;
use DockerCloud\Test\API\ContainerTest as APITest;
use DockerCloud\Test\Model\AbstractModelTest;

class PortTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        $data = (new Container(json_decode(APITest::getMockData())))->getContainerPorts();

        return json_encode(array_pop($data));
    }
}
