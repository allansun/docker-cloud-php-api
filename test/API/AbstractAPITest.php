<?php


namespace DockerCloud\Test\API;

use DockerCloud\Client;
use DockerCloud\Model\AbstractModel;
use DockerCloud\Model\Response\MetaData;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * Class AbstractAPITest
 *
 * @package DockerCloud\Test\API
 */
abstract class AbstractAPITest extends \PHPUnit_Framework_TestCase
{
    static public function setUpBeforeClass()
    {
        Client::configure(getenv('USERNAME'), getenv('APIKEY'));
    }

    /**
     * @param $status
     * @param $body
     *
     * @return $this
     * @throws \Exception
     */
    protected function mockResponse($status, $body)
    {
        if ($body instanceof AbstractModel) {
            $body = json_encode($body->getArrayCopy());
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

    /**
     * @param                                      $status
     * @param string|AbstractModel|AbstractModel[] $body
     *
     * @return AbstractAPITest
     */
    protected function mockGetListResponse($status, $body)
    {
        if (is_string($body)) {
            $body = json_decode($body);
        }
        if ($body instanceof AbstractModel) {
            $body = [$body->getArrayCopy()];
        }
        if (!is_array($body) && null !== $body) {
            $body = [$body];
        }

        $MetaData = new MetaData();
        $MetaData->setLimit(25)
            ->setTotalCount(count($body));

        return $this->mockResponse($status, json_encode([
            'meta'    => $MetaData->getArrayCopy(),
            'objects' => $body
        ]));
    }

    /**
     * @param Response[] $responses
     *
     * @return $this
     * @throws \Exception
     */
    protected function mockResponses($responses)
    {
        Client::getInstance()->setDefaultOption('handler',
            HandlerStack::create(new MockHandler($responses))
        );

        return $this;
    }

}