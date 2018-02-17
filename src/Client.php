<?php


namespace DockerCloud;

use GuzzleHttp;
use WebSocket;
use Zend\Json\Json;
use Zend\Uri\Uri;

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

    private $namespace = null;

    /**
     * Client constructor.
     *
     * @param $username
     * @param $apiKey
     * @param $namespace String Namespace for using an organisation with docker cloud
     */
    private function __construct($username, $apiKey, $namespace = null)
    {
        Json::$useBuiltinEncoderDecoder = true;

        $this->defaultOptions = [
            'auth'    => [$username, $apiKey],
            'headers' => [
                'Accepts' => 'application/json'
            ]
        ];

        $this->namespace = $namespace;
    }

    /**
     * @param                    $method
     * @param                    $uri
     * @param array              $options
     * @param null|bool|\Closure $successCallback
     * @param null|bool|\Closure $failCallback
     *
     * @return bool|null|\StdClass
     * @throws Exception
     */
    public function request($method, $uri, $options = [], $successCallback = null, $failCallback = null)
    {

        if (!$successCallback && !$failCallback) {
            $json = null;
            // If there's no callbacks defined we assume this is a RESTful request
            Logger::getInstance()->debug($method . ' ' . $uri . ' ' . json_encode($options));
            $options = array_merge($this->defaultOptions, $options);
            $guzzle  = new GuzzleHttp\Client(['base_uri' => self::BASE_URL_REST]);
            $res     = $guzzle->request($method, $uri, $options);
            if ($res->getHeader('content-type')[0] == 'application/json') {
                $contents = $res->getBody()->getContents();
                Logger::getInstance()->debug($contents);
                $json = json_decode($contents);
            } else {
                throw new Exception("Server did not send JSON. Response was \"{$res->getBody()->getContents()}\"");
            }

            return $json;
        } else {
            // Use the STREAM API end point
            $Uri = new Uri(self::BASE_URL_STREAM);
            $Uri->setUserInfo($this->defaultOptions['auth'][0] . ':' . $this->defaultOptions['auth'][1]);
            $Uri->setPath($uri);
            if (isset($options['query'])) {
                $Uri->setQuery($options['query']);
            }

            $WSClient = new WebSocket\Client($Uri);

            Logger::getInstance()->debug($Uri);

            if (!($successCallback instanceof \Closure)) {
                $successCallback = function ($response) {
                    $info = json_decode($response);
                    if (property_exists($info, 'output')) {
                        Logger::getInstance()->info(json_decode($response)->output);
                    } elseif ($info->type == 'error') {
                        // output error info
                        Logger::getInstance()->info($info->message);
                    }
                };
            }
            if (!($failCallback instanceof \Closure)) {
                $failCallback = function (\Exception $exception) {
                    Logger::getInstance()->info($exception->getMessage());
                };
            }

            try {
                while ($response = $WSClient->receive()) {
                    $successCallback($response);
                }
            } catch (\Exception $e) {
                $failCallback($e);
            }

            return true;
        }
    }

    /**
     * @param $username
     * @param $apiKey
     * @param $namespace String Namespace for using an organisation with docker cloud
     *
     * @return Client
     */
    public static function configure($username, $apiKey, $namespace = null)
    {
        self::$instance = new Client($username, $apiKey, $namespace);

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

    /**
     * @return null|String
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}