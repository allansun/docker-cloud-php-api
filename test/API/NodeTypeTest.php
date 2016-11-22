<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\NodeType as API;
use DockerCloud\API\Provider as ProviderAPI;
use DockerCloud\Model\NodeType as Model;
use DockerCloud\Model\Response\NodeTypeGetListResponse;

class NodeTypeTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
        "availability_zones": ["custom"],
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

        $this->mockResponse(200, ProviderTest::getMockData());
        $Provider = $ProviderAPI->getByUri($Model->getProvider());

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->get($Provider->getName(), $Model->getName());
        $this->assertInstanceOf(Model::class, $Model);
    }

    public function testGetListByUri()
    {
        $this->mockGetListResponse(200, $this->getMockData());
        $API = new API();
        $this->assertInstanceOf(NodeTypeGetListResponse::class, $API->getListByUri('mock_uri'));
    }
}
