<?php


namespace DockerCloud\Test\Model\Service;


use DockerCloud\Model\Service;
use DockerCloud\Model\Service\Link as Model;
use DockerCloud\Test\API\ServiceTest as APITest;
use DockerCloud\Test\Model\AbstractModelTest;

class LinkTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        $data = (new Service(json_decode(APITest::getMockData())))->getLinkedToService();

        return \Zend\Json\Encoder::encode(array_pop($data));
    }

    public function testBuild()
    {
        $FromService = new Service('{"resource_uri":"DB"}');
        $ToService   = new Service('{"resource_uri":"APP"}');

        $Model = Model::build($FromService, $ToService, 'db');
        $this->assertEquals('DB', $Model->getFromService());
        $this->assertEquals('APP', $Model->getToService());
        $this->assertEquals('db', $Model->getName());
    }
}
