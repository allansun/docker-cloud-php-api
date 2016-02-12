<?php


namespace DockerCloud\Test\API;

use DockerCloud\API\AvailabilityZone as API;
use DockerCloud\Model\AvailabilityZone as Model;

class AvailabilityZoneTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
        "available": true,
        "name": "ap-northeast-1a",
        "region": "/api/infra/v1/region/az/ap-northeast-1/",
        "resource_uri": "/api/infra/v1/az/aws/ap-northeast-1/ap-northeast-1a/"
        }';
    }

    /**
     * @return Model
     */
    public function testGetList()
    {
        $this->mockGetListResponse(200, $this->getMockData());

        $API               = new API();
        $GetListResponse   = $API->getList();
        $availabilityZones = $GetListResponse->getObjects();
        $this->assertInternalType('array', $availabilityZones);
        $this->assertGreaterThanOrEqual(1, $GetListResponse->getMeta()->getTotalCount());

        return array_pop($availabilityZones);
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
        $this->mockResponse(200, $this->getMockData());

        $uriParts     = explode('/', $Model->getResourceUri());
        $providerName = $uriParts[5];
        $regionName   = $uriParts[6];
        $azName       = $uriParts[7];

        $API   = new API();
        $Model = $API->get($providerName, $regionName, $azName);
        $this->assertInstanceOf(Model::class, $Model);
    }

}
