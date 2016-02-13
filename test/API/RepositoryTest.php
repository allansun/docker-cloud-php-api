<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Repository as API;
use DockerCloud\Model\Repository as Model;
use Faker\Factory;

class RepositoryTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
            "in_use": false,
            "name": "quay.io/tutum/ubuntu",
            "registry": "/api/repo/v1/registry/quay.io/",
            "resource_uri": "/api/repo/v1/repository/quay.io/tutum/ubuntu/",
        }';
    }

    public function testCreate()
    {
        $Faker = Factory::create();
        $API   = new API();
        $Model = new Model;
        $Model->setName($Faker->domainName . '/' . $Faker->word . '/' . $Faker->word);
        $this->mockResponse(200, $this->getMockData());
        $Model = $API->create($Model, $Faker->userName, $Faker->password);
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @return Model
     * @depends testCreate
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
        $Model = $API->get($Model->getName());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testUpdateCredentials(Model $Model)
    {
        $Faker = Factory::create();
        $API   = new API();

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->updateCredentials($Model->getName(), $Faker->userName, $Faker->password);
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testDelete(Model $Model)
    {

        $API = new API();

        $this->mockResponse(200, $this->getMockData());
        $Model = $API->delete($Model->getName());
        $this->assertInstanceOf(Model::class, $Model);
    }
}
