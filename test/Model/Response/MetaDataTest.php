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
            json_decode('{"limit":25,"next":"next","offset":1,"previous":"previouse","total_count":1}',true)
        );

        return \Zend\Json\Encoder::encode($data);
    }


}
