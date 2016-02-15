<?php


namespace DockerCloud\Test\Model;

use DockerCloud\Model\Service as Model;
use DockerCloud\Test\API\ServiceTest as APITest;

class ServiceTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        return APITest::getMockData();
    }


    public function testAddContainerEnvvar()
    {
        /** @var Model $Model * */
        $Model = new $this->modelClass;


        $Model->addContainerEnvvar(new Model\EnvironmentVariable([
            'key'   => 'test_key',
            'value' => 'test_value',
        ]));

        $EnvironmentVairable = $Model->getContainerEnvvars()[0];

        $this->assertEquals('test_key', $EnvironmentVairable->getKey());
        $this->assertEquals('test_value', $EnvironmentVairable->getValue());
    }

    public function testAddContainerPort()
    {
        /** @var Model $Model * */
        $Model = new $this->modelClass;

        $Model->addContainerPort((new Model\Port())
            ->setInnerPort('8080')
            ->setOuterPort('80')
        );

        $Port = $Model->getContainerPorts()[0];

        $this->assertEquals('8080', $Port->getInnerPort());
        $this->assertEquals('80', $Port->getOuterPort());
    }

    public function testAddBinding()
    {
        /** @var Model $Model * */
        $Model = new $this->modelClass;

        $Model->addBinding((new Model\Binding())
            ->setContainerPath('container_path')
            ->setHostPath('host_path')
        );

        $Binding = $Model->getBindings()[0];

        $this->assertEquals('container_path', $Binding->getContainerPath());
        $this->assertEquals('host_path', $Binding->getHostPath());
    }

    public function testAddLinkedServices()
    {
        /** @var Model $Model * */
        $Model = new $this->modelClass;

        $Model->addLinkedFromService((new Model\Link())
            ->setName('from_service')
        );
        $Model->addLinkedToService((new Model\Link())
            ->setName('to_service')
        );

        $this->assertEquals('from_service', $Model->getLinkedFromService()[0]->getName());
        $this->assertEquals('to_service', $Model->getLinkedToService()[0]->getName());
    }
}
