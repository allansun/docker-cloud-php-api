<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\ServiceTrigger as API;
use DockerCloud\Model\ServiceTrigger as Model;
use Faker\Factory;

class ServiceTriggerTest extends AbstractAPITest
{
    static protected $uuid;

    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
            "type": "action",
            "action": "update",
            "parents": [
                "/api/app/v1/container/0b0e3538-88df-4f07-9aed-3a3cc4175076/"
            ],
            "resource_uri": "/api/app/v1/action/49f0efe8-a704-4a10-b02f-f96344fabadd/",
            "state": "Success"
        }';
    }

    protected function getUuid()
    {
        if (!static::$uuid) {
            $Facker       = Factory::create();
            static::$uuid = $Facker->uuid;
        }

        return static::$uuid;
    }


    public function testCreate()
    {
        $API   = new API($this->getUuid());
        $Model = new Model;
        $this->mockResponse(200, $this->getMockData());
        $Model = $API->create($Model);
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @return Model
     * @depends testCreate
     */
    public function testGetList()
    {
        $this->mockGetListResponse(200, $this->getMockData());

        $API             = new API($this->getUuid());
        $GetListResponse = $API->getList();
        $nodeTypes       = $GetListResponse->getObjects();
        $this->assertInternalType('array', $nodeTypes);
        $this->assertGreaterThanOrEqual(1, $GetListResponse->getMeta()->getTotalCount());

        return array_pop($nodeTypes);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testGetByUri(Model $Model)
    {

        $API = new API($this->getUuid());

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->getByUri($Model->getResourceUri());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testDelete(Model $Model)
    {

        $API = new API($this->getUuid());

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->delete($Model->getResourceUri());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testCall(Model $Model)
    {

        $API = new API($this->getUuid());

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->call($Model->getResourceUri(), 1);
        $this->assertInstanceOf(Model::class, $Model);
    }

}
