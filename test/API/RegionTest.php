<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Provider as ProviderAPI;
use DockerCloud\API\Region as API;
use DockerCloud\Model\Region as Model;

class RegionTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
        "availability_zones": [],
        "available": true,
        "label": "Amsterdam 2",
        "name": "ams2",
        "node_types": [
            "/api/infra/v1/nodetype/digitalocean/1gb/",
            "/api/infra/v1/nodetype/digitalocean/2gb/",
            "/api/infra/v1/nodetype/digitalocean/4gb/",
            "/api/infra/v1/nodetype/digitalocean/8gb/",
            "/api/infra/v1/nodetype/digitalocean/16gb/",
            "/api/infra/v1/nodetype/digitalocean/32gb/",
            "/api/infra/v1/nodetype/digitalocean/48gb/",
            "/api/infra/v1/nodetype/digitalocean/64gb/"
        ],
        "provider": "/api/infra/v1/provider/digitalocean/",
        "resource_uri": "/api/infra/v1/region/digitalocean/ams2/"
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
        $regions         = $GetListResponse->getObjects();
        $this->assertInternalType('array', $regions);
        $this->assertGreaterThanOrEqual(1, $GetListResponse->getMeta()->getTotalCount());

        return array_pop($regions);
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
     * Because at the moment DockerCloud's API doesn't reply 'provider' as promised in document
     * I have to manually get a result from ProviderAPI to test 'get' function by RegionAPI
     */
    public function testGet()
    {

        $API         = new API();
        $ProviderAPI = new ProviderAPI();

        // Get whatever first replied responsed from server, I don't care...
        $this->mockGetListResponse(200, ProviderTest::getMockData());
        $ProviderGetListResponse = $ProviderAPI->getList();
        $Provider                = $ProviderGetListResponse->getObjects()[0];

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->getByUri($Provider->getRegions()[0]);

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->get($Provider->getName(), $Model->getName());
        $this->assertInstanceOf(Model::class, $Model);
    }

}
