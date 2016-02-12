<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Stack as API;
use DockerCloud\Model\Stack as Model;
use Faker\Factory as FackerFactory;

class StackTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
            "deployed_datetime": "Mon, 13 Oct 2014 11:01:43 +0000",
            "destroyed_datetime": null,
            "nickname": "deployment stack",
            "name": "dockercloud-app",
            "resource_uri": "/api/app/v1/stack/7fe7ec85-58be-4904-81da-de2219098d7c/",
            "services": [
            "/api/app/v1/service/09cbcf8d-a727-40d9-b420-c8e18b7fa55b/"
            ],
            "state": "Running",
            "synchronized": true,
            "uuid": "09cbcf8d-a727-40d9-b420-c8e18b7fa55b"
        }';
    }

    /**
     * @return Model
     */
    public function testCreate()
    {
        $this->mockResponse(200, $this->getMockData());

        $Facker   = FackerFactory::create();
        $StackAPI = new API();
        $Model    = new Model();
        $Model->setName('test-' . $Facker->uuid);
        $Model = $StackAPI->create($Model);
        $this->assertInstanceOf(Model::class, $Model);

        return $Model;
    }

    /**
     * @return Model
     * @depends testCreate
     */
    public function testGetList()
    {
        $this->mockGetListResponse(200, $this->getMockData());

        $StackAPI         = new API();
        $StackGetResponse = $StackAPI->getList();
        $stacks           = $StackGetResponse->getObjects();
        $this->assertInternalType('array', $stacks);
        $this->assertGreaterThanOrEqual(1, $StackGetResponse->getMeta()->getTotalCount());

        return array_pop($stacks);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testGetByUri(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->getByUri($Model->getResourceUri());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testCreate
     */
    public function testGet(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->get($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testCreate
     */
    public function testTerminate(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->terminate($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }
}
