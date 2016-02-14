<?php


namespace DockerCloud;

use GuzzleHttp;

class Client
{
    const BASE_URL_REST = 'https://cloud.docker.com';
    const BASE_URL_STREAM = 'wss://ws.cloud.docker.com';

    /**
     * @var Client
     */
    static private $instance;

    /**
     * @var array
     */
    private $defaultOptions = [];

    /**
     * Client constructor.
     *
     * @param $username
     * @param $apiKey
     */
    private function __construct($username, $apiKey)
    {
        $config = [
            'base_uri' => self::BASE_URL_REST,
        ];

        $this->guzzle         = new GuzzleHttp\Client($config);
        $this->defaultOptions = [
            'auth'    => [$username, $apiKey],
            'headers' => [
                'Accepts' => 'application/json'
            ]
        ];
    }

    /**
     * @param                    $method
     * @param                    $uri
     * @param array              $options
     * @param null|bool|\Closure $successCallback
     * @param null|bool|\Closure $failCallback
     *
     * @return null|\StdClass
     * @throws Exception
     */
    public function request($method, $uri, $options = [], $successCallback = null, $failCallback = null)
    {
        $json = null;
        Logger::getInstance()->log('URI ' . $uri);
        $options = array_merge($this->defaultOptions, $options);
        try {
            if (!$successCallback && !$failCallback) {
                // If there's no callbacks defined we assume this is a RESTful request
                $guzzle = new GuzzleHttp\Client(['base_uri' => self::BASE_URL_REST]);
                $res    = $guzzle->request($method, $uri, $options);
                if ($res->getHeader('content-type')[0] == 'application/json') {
                    $contents = $res->getBody()->getContents();
                    Logger::getInstance()->log($contents);
                    $json = json_decode($contents);
                } else {
                    throw new Exception("Server did not send JSON. Response was \"{$res->getBody()->getContents()}\"");
                }
            } else {
                // Use the STREAM API end point
                $guzzle = new GuzzleHttp\Client(['base_uri' => self::BASE_URL_STREAM]);
                if (!($successCallback instanceof \Closure)) {
                    $successCallback = function (GuzzleHttp\Psr7\Response $response) {
                        Logger::getInstance()->log($response->getBody());
                    };
                }
                if (!($failCallback instanceof \Closure)) {
                    $failCallback = function (GuzzleHttp\Exception\ServerException $exception) {
                        Logger::getInstance()->log($exception->getResponse()->getBody());
                    };
                }
                $guzzle->requestAsync($method, $uri, $options)->then($successCallback, $failCallback)->wait();
            }
        } catch (GuzzleHttp\Exception\ClientException $ce) {
            Logger::getInstance()->log('Headers', $ce->getRequest()->getHeaders());
            Logger::getInstance()->log($ce->getResponse()->getBody()->getContents());
            throw $ce;
        }

        return $json;
    }

    /**
     * @param $username
     * @param $apiKey
     *
     * @return Client
     */
    public static function configure($username, $apiKey)
    {
        self::$instance = new Client($username, $apiKey);

        return self::$instance;
    }

    /**
     * @return Client
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (self::$instance instanceof Client) {
            return self::$instance;
        } else {
            throw new Exception("Must run Client::configure() first!");
        }
    }

    /**
     * @param $option
     * @param $value
     *
     * @return $this
     */
    public function setDefaultOption($option, $value)
    {
        $this->defaultOptions[$option] = $value;

        return $this;
    }
}