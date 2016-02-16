<?php


namespace DockerCloud\Test\Model\NodeCluster;


use DockerCloud\Model\NodeCluster;
use DockerCloud\Model\NodeCluster\ProviderOptions as Model;
use DockerCloud\Test\API\NodeClusterTest as APITest;
use DockerCloud\Test\Model\AbstractModelTest;

class ProviderOptionsTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        $data = (new NodeCluster(json_decode(APITest::getMockData())))->getProviderOptions();

        return \Zend\Json\Encoder::encode($data);
    }
}
