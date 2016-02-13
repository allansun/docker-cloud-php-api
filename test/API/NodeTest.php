<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Node as API;
use DockerCloud\API\Provider as ProviderAPI;
use DockerCloud\Model\Node as Model;

class NodeTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
        "availability_zones": [],
        "available": true,
        "label": "1GB",
        "name": "1gb",
        "provider": "/api/infra/v1/provider/digitalocean/",
        "regions": [
            "/api/infra/v1/region/digitalocean/ams1/",
            "/api/infra/v1/region/digitalocean/sfo1/",
            "/api/infra/v1/region/digitalocean/nyc2/",
            "/api/infra/v1/region/digitalocean/ams2/",
            "/api/infra/v1/region/digitalocean/sgp1/",
            "/api/infra/v1/region/digitalocean/lon1/",
            "/api/infra/v1/region/digitalocean/nyc3/",
            "/api/infra/v1/region/digitalocean/nyc1/"
        ],
        "resource_uri": "/api/infra/v1/nodetype/digitalocean/1gb/"
        }';
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

        $API         = new API();
        $ProviderAPI = new ProviderAPI();

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
}
