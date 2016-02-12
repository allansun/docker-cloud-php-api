<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Provider as API;
use DockerCloud\Model\Provider as Model;

class ProviderTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
        "available": true,
        "label": "Digital Ocean",
        "name": "digitalocean",
        "regions": [
            "/api/infra/v1/region/digitalocean/ams1/",
            "/api/infra/v1/region/digitalocean/ams2/",
            "/api/infra/v1/region/digitalocean/ams3/",
            "/api/infra/v1/region/digitalocean/lon1/",
            "/api/infra/v1/region/digitalocean/nyc1/",
            "/api/infra/v1/region/digitalocean/nyc2/",
            "/api/infra/v1/region/digitalocean/nyc3/",
            "/api/infra/v1/region/digitalocean/sfo1/",
            "/api/infra/v1/region/digitalocean/sgp1/"
        ],
        "resource_uri": "/api/infra/v1/provider/digitalocean/"
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
        $providers       = $GetListResponse->getObjects();
        $this->assertInternalType('array', $providers);
        $this->assertGreaterThanOrEqual(1, $GetListResponse->getMeta()->getTotalCount());

        return array_pop($providers);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testGet(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->get($Model->getName());
        $this->assertInstanceOf(Model::class, $Model);
    }

}
