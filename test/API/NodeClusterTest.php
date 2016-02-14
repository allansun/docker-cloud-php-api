<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\NodeCluster as API;
use DockerCloud\API\NodeType as NodeTypeAPI;
use DockerCloud\API\Region as RegionAPI;
use DockerCloud\Model\NodeCluster as Model;
use Faker\Factory as FackerFactory;

class NodeClusterTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return <<<JSON
{
    "current_num_nodes": 1,
    "deployed_datetime": "Tue, 16 Sep 2014 17:01:15 +0000",
    "destroyed_datetime": null,
    "disk": 60,
    "nickname": "my test cluster",
    "name": "TestCluster",
    "node_type": "/api/infra/v1/nodetype/aws/t2.micro/",
    "nodes": [
        "/api/infra/v1/node/75d20367-0948-4f10-8ba4-ffb4d16ed3c6/"
    ],
    "region": "/api/infra/v1/region/aws/us-east-1/",
    "resource_uri": "/api/infra/v1/nodecluster/5516df0b-721e-4470-b350-741ff22e63a0/",
    "state": "Deployed",
    "tags": [
        {"name": "tag_one"},
        {"name": "tag-two"},
        {"name": "tagthree3"}
    ],
    "target_num_nodes": 2,
    "uuid": "5516df0b-721e-4470-b350-741ff22e63a0",
    "provider_options": {
        "vpc": {
            "id": "vpc-aa1c70d4",
            "subnets": ["subnet-aaa7d94f", "subnet-aa15fa64"],
            "security_groups": ["sg-aa1c70d4"]
        },
        "iam": {
            "instance_profile_name": "my_instance_profile"
        }
    }
}
JSON;
    }

    /**
     * @return Model
     */
    public function testCreate()
    {
        $API       = new API();
        $modelData = $this->getTestModel();
        $this->mockResponse(200, $this->getMockData());
        $Model = $API->create($modelData);
        $this->assertInstanceOf(Model::class, $Model);

        return $Model;
    }

    /**
     * @return Model
     */
    private function getTestModel()
    {
        $Facker      = FackerFactory::create();
        $Model       = new Model();
        $RegionAPI   = new RegionAPI();
        $NodeTypeAPI = new NodeTypeAPI();

        $this->mockResponse(200, RegionTest::getMockData());
        $Region = $RegionAPI->get('aws', 'eu-west-1');
        $this->mockResponse(200, NodeTypeTest::getMockData());
        $NodeType = $NodeTypeAPI->get('aws', 't2.nano');

        $Model->setName('Cluster-test-' . $Facker->lexify())
            ->setRegion($Region->getResourceUri())
            ->setNodeType($NodeType->getResourceUri())
            ->setTargetNumNodes(1)
            ->setDisk(10)
            ->setTags(['unit-test']);

        return $Model;
    }

    /**
     * @return Model
     * @depends testCreate
     */
    public function testGetList()
    {
        $this->mockGetListResponse(200, $this->getMockData());

        $NodeClusterAPI         = new API();
        $NodeClusterGetResponse = $NodeClusterAPI->getList();
        $stacks                 = $NodeClusterGetResponse->getObjects();
        $this->assertInternalType('array', $stacks);
        $this->assertGreaterThanOrEqual(1, $NodeClusterGetResponse->getMeta()->getTotalCount());

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
    public function testDeploy(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->deploy($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testCreate
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
