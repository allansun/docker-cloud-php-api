<?php


namespace DockerCloud\Test\API;

use DockerCloud\Client;
use DockerCloud\Model\AbstractModel;
use DockerCloud\Model\Common\ResponseMetaData;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

abstract class AbstractAPITest extends \PHPUnit_Framework_TestCase
{
    static public function setUpBeforeClass()
    {
        Client::configure(getenv('USERNAME'), getenv('APIKEY'));
    }

    protected function mockResponse($status, $body)
    {
        if ($body instanceof AbstractModel) {
            $body = $body->jsonSerialize();
        }

        if (!is_string($body)) {
            $body = json_encode($body);
        }

        Client::getInstance()->setDefaultOption('handler',
            HandlerStack::create(new MockHandler([
                new Response($status, ['Content-Type' => 'application/json'], $body)
            ]))
        );

        return $this;
    }

    protected function mockGetListResponse($status, $body)
    {
        if (is_string($body)) {
            $body = json_decode($body);
        }
        if ($body instanceof AbstractModel) {
            $body = $body->getArrayCopy();
        }
        if(!is_array($body)){
            $body = [$body];
        }

        $MetaData = new ResponseMetaData();
        $MetaData->setLimit(25)
            ->setTotalCount(count($body));

        return $this->mockResponse($status, json_encode([
            'meta'    => $MetaData->getArrayCopy(),
            'objects' => $body
        ]));
    }
}