<?php


namespace DockerCloud\Test\API;

use DockerCloud\API\Service as API;
use DockerCloud\Exception;
use DockerCloud\Model\Service as Model;
use Faker\Factory;
use GuzzleHttp\Psr7\Response;
use Zend\Json\Encoder;

class RealAbstractApplicationAPITest extends AbstractAPITest
{
    public function testWaitForState()
    {
        $Facker      = Factory::create();
        $MockedModel = new Model(json_decode(ServiceTest::getMockData(), true));
        $this->mockResponses([
            new Response(200, ['Content-Type' => 'application/json'],
                Encoder::encode($MockedModel->setState(Model::STATE_NOT_RUNNING)->getArrayCopy(['state']))),
            new Response(200, ['Content-Type' => 'application/json'],
                Encoder::encode($MockedModel->setState(Model::STATE_STARTING)->getArrayCopy(['state']))),
            new Response(200, ['Content-Type' => 'application/json'],
                Encoder::encode($MockedModel->setState(Model::STATE_RUNNING)->getArrayCopy(['state']))),
        ]);

        $API   = new API();
        $Model = $API->get($Facker->uuid);
        $API->waitForState($Model, Model::STATE_RUNNING, 0.1);
    }

    public function testWaitForStateTimeOut()
    {
        $Facker      = Factory::create();
        $MockedModel = new Model(json_decode(ServiceTest::getMockData(), true));
        $this->mockResponses([
            new Response(200, ['Content-Type' => 'application/json'],
                Encoder::encode($MockedModel->setState(Model::STATE_NOT_RUNNING)->getArrayCopy())),
            new Response(200, ['Content-Type' => 'application/json'],
                Encoder::encode($MockedModel->setState(Model::STATE_STARTING)->getArrayCopy())),
        ]);

        $API   = new API();
        $Model = $API->get($Facker->uuid);
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('/.*timed out.*/');
        $API->waitForState($Model, Model::STATE_RUNNING, 0.1, 0);
    }
}