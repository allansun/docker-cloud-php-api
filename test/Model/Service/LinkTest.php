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

        return json_encode(array_pop($data));
    }
}
