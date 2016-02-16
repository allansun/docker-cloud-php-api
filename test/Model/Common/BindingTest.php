<?php


namespace DockerCloud\Test\Model\Common;


use DockerCloud\Model\Common\Binding as Model;
use DockerCloud\Model\Container;
use DockerCloud\Test\API\ContainerTest as APITest;
use DockerCloud\Test\Model\AbstractModelTest;

class BindingTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        $data = (new Container(json_decode(APITest::getMockData())))->getBindings();

        return \Zend\Json\Encoder::encode(array_pop($data));
    }
}
