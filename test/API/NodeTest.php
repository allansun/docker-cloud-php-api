<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Node as API;
use DockerCloud\Model\Node as Model;
use DockerCloud\Model\Response\NodeGetListResponse;

class NodeTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return <<<JSON
{
    "availability_zone": "/api/infra/v1/az/testing-provider/testing-region/testing-az/",
    "cpu": 1,
    "current_num_containers": 4,
    "deployed_datetime": "Tue, 16 Sep 2014 17:01:15 +0000",
    "destroyed_datetime": null,
    "disk": 60,
    "docker_execdriver": "native-0.2",
    "docker_graphdriver": "aufs",
    "docker_version": "1.5.0",
    "external_fqdn": "fc1a5bb9-user.node.dockerapp.io",
    "last_seen": "Thu, 25 Sep 2014 13:14:44 +0000",
    "memory": 1792,
    "nickname": "fc1a5bb9-user.node.dockerapp.io",
    "last_metric": {
        "cpu": 1.3278507035616,
        "disk": 462479360,
        "memory": 763170816
    },
    "node_cluster": "/api/infra/v1/nodecluster/d787a4b7-d525-4061-97a0-f423e8f1d229/",
    "node_type": "/api/infra/v1/nodetype/testing-provider/testing-type/",
    "public_ip": "10.45.2.11",
    "region": "/api/infra/v1/region/testing-provider/testing-region/",
    "resource_uri": "/api/infra/v1/node/fc1a5bb9-17f5-4819-b667-8c7cd819e949/",
    "state": "Deployed",
    "tags": [
        {"name": "tag_one"},
        {"name": "tag-two"}
    ],
    "tunnel": "https://tunnel01.cloud.docker.com:12345",
    "uuid": "fc1a5bb9-17f5-4819-b667-8c7cd819e949"
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
    public function testUpdate(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API = new API();
        $Model->setTags(['unit-test-update']);
        $Model = $API->update($Model);
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testDockerUpgrade(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->dockerUpgrade($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testHealthCheck(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->healthCheck($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testTerminate(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->terminate($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    public function testGetListByUri()
    {
        $this->mockGetListResponse(200, $this->getMockData());
        $API = new API();
        $this->assertInstanceOf(NodeGetListResponse::class, $API->getListByUri('mock_uri'));
    }
}
