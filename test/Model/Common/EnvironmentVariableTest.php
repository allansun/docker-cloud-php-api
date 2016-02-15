<?php


namespace DockerCloud\Test\Model\Common;


use DockerCloud\Model\Common\EnvironmentVariable as Model;
use DockerCloud\Model\Container;
use DockerCloud\Test\API\ContainerTest as APITest;
use DockerCloud\Test\Model\AbstractModelTest;

class EnvironmentVariableTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        $data = (new Container(json_decode(APITest::getMockData())))->getContainerEnvvars();

        return json_encode(array_pop($data));
    }

    public function testBuild()
    {
        $Model = Model::build('test_key', 'test_value');
        $this->assertEquals('test_key', $Model->getKey());
        $this->assertEquals('test_value', $Model->getValue());
    }
}
