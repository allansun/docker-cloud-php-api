<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Action as API;
use DockerCloud\Model\Action as Model;
use DockerCloud\Model\Response\ActionGetListResponse;

class ActionTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return <<<JSON
{
    "action": "Cluster Create",
    "body": "{\"image\": \"tutum/ubuntu-quantal:latest/\", \"name\": \"test_cluster\"}",
    "end_date": "Wed, 17 Sep 2014 08:26:22 +0000",
    "ip": "56.78.90.12",
    "is_user_action": true,
    "can_be_canceled": false,
    "can_be_retried": false,
    "location": "New York, USA",
    "method": "POST",
    "object": "/api/infra/v1/cluster/eea638f4-b77a-4183-b241-22dbd7866f22/",
    "path": "/api/infra/v1/cluster/",
    "resource_uri": "/api/audit/v1/action/6246c558-976c-4df6-ba60-eb1a344a17af/",
    "start_date": "Wed, 17 Sep 2014 08:26:22 +0000",
    "state": "Success",
    "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.78.2 (KHTML, like Gecko) ",
    "uuid": "6246c558-976c-4df6-ba60-eb1a344a17af"
}
JSON;
    }

    /**
     * @return Model
     */
    public function testGetList()
    {
        $this->mockGetListResponse(200, $this->getMockData());

        $API             = new API();
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
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->getByUri($Model->getResourceUri());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testGet(Model $Model)
    {

        $API = new API();

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->get($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }


    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testCancel(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->cancel($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testRetry(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->retry($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    public function testGetListByUri()
    {
        $this->mockGetListResponse(200, $this->getMockData());
        $API = new API();
        $this->assertInstanceOf(ActionGetListResponse::class, $API->getListByUri('mock_uri'));
    }
}
