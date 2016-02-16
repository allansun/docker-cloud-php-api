<?php


namespace DockerCloud;

use GuzzleHttp;

class Client
{
    const BASE_URL_REST = 'https://cloud.docker.com';
    const BASE_URL_STREAM = 'ws.cloud.docker.com';

    /**
     * @var Client
     */
    static private $instance;

    /**
     * @var array
     */
    private $defaultOptions = [];

    /**
     * @var \WebSocket\Client
     */
    protected $WEClient;

    /**
     * Client constructor.
     *
     * @param $username
     * @param $apiKey
     */
    private function __construct($username, $apiKey)
    {
        \Zend\Json\Json::$useBuiltinEncoderDecoder = true;
        $config                                    = [
            'base_uri' => self::BASE_URL_REST,
        ];

        $this->guzzle         = new GuzzleHttp\Client($config);
        $this->defaultOptions = [
            'auth'    => [$username, $apiKey],
            'headers' => [
                'Accepts' => 'application/json'
            ]
        ];

        $this->webSocketUri = "wss://${username}:${apiKey}@" . self::BASE_URL_STREAM;
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
        $json    = null;
        $options = array_merge($this->defaultOptions, $options);

        Logger::getInstance()->log($method . ' ' . $uri . ' ' . json_encode($options));

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

            $WSClient = new \WebSocket\Client($this->webSocketUri . $uri . http_build_query($options));
            if (!($successCallback instanceof \Closure)) {
                $successCallback = function ($response) {
                    Logger::getInstance()->log($response);
                };
            }
            if (!($failCallback instanceof \Closure)) {
                $failCallback = function (\Exception $exception) {
                    Logger::getInstance()->log($exception->getMessage());
                };
            }
            try {
                $WSClient->send('');
                $successCallback($WSClient->receive());
            } catch (\Exception $e) {
                $failCallback($e);
            }
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
            throw new Exception('Must run Client::configure() first!');
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