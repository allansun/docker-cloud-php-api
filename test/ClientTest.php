<?php


namespace DockerCloud\Test;


use DockerCloud\Client;
use DockerCloud\Exception;
use GuzzleHttp;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstanceWithoutConfiguring()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('/Must run.*/');
        Client::getInstance();
    }

    /**
     * @depends testGetInstanceWithoutConfiguring
     */
    public function testGetInstance()
    {
        Client::configure('username', 'password');
        $this->assertInstanceOf(Client::class, Client::getInstance());
    }

    public function testInvalidJsonReturned()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('/Server did not send JSON.*/');

        Client::getInstance()->setDefaultOption('handler',
            HandlerStack::create(new MockHandler([
                new Response(200, ['Content-Type' => 'application/text'], 'ok')
            ]))
        );

        Client::getInstance()->request('GET', '/');
    }

    public function testClientException()
    {
        $this->expectException(GuzzleHttp\Exception\ClientException::class);

        Client::getInstance()->setDefaultOption('handler',
            HandlerStack::create(new MockHandler([
                new Response(404, ['Content-Type' => 'application/text'], 'ok')
            ]))
        );

        Client::getInstance()->request('GET', '/');
    }

    public function testStreamAPI()
    {
        Client::getInstance()->setDefaultOption('handler',
            HandlerStack::create(new MockHandler([
                new Response(200, ['Content-Type' => 'application/text'], '{"output":"Normal result"}')
            ]))
        );

        Client::getInstance()->request('GET', '/', ['query' => ['ok' => 'ok']], true, true);
    }

    public function testStreamAPIWithFailedResponse()
    {
        Client::getInstance()->setDefaultOption('handler',
            HandlerStack::create(new MockHandler([
                new Response(500, ['Content-Type' => 'application/text'], 'ok')
            ]))
        );

        Client::getInstance()->request('GET', '/', ['query' => ['ok' => 'ok']], true, true);
    }
}
