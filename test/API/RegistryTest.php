<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Registry as API;
use DockerCloud\Model\Registry as Model;

class RegistryTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return <<<JSON
{
    "host": "registry-1.docker.io",
    "is_docker_registry": true,
    "is_ssl": true,
    "name": "Docker Hub",
    "port": 443,
    "resource_uri": "/api/repo/v1/registry/registry-1.docker.io/"
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
    public function testGet(Model $Model)
    {

        $API = new API();

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->get($Model->getHost());
        $this->assertInstanceOf(Model::class, $Model);
    }
}
