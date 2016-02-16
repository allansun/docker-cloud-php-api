<?php


namespace DockerCloud\Test\Model\NodeCluster\ProviderOption;


use DockerCloud\Model\NodeCluster;
use DockerCloud\Model\NodeCluster\ProviderOption\IAM as Model;
use DockerCloud\Test\API\NodeClusterTest as APITest;
use DockerCloud\Test\Model\AbstractModelTest;

class IAMTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        $data = (new NodeCluster(json_decode(APITest::getMockData())))->getProviderOptions()->getIam();

        return \Zend\Json\Encoder::encode($data);
    }
}
