<?php


namespace DockerCloud\Test\Model\Service;


use DockerCloud\Model\Response\MetaData as Model;
use DockerCloud\Test\Model\AbstractModelTest;

class MetaDataTest extends AbstractModelTest
{
    protected $modelClass = Model:: class;

    /**
     * @return string
     */
    protected function getMockData()
    {
        $data = new Model(
            json_decode('{"meta":{"limit":25,"next":null,"offset":null,"previous":null,"total_count":1}')
        );

        return \Zend\Json\Encoder::encode($data);
    }


}
