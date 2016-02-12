<?php


namespace DockerCloud\API\Response;


use DockerCloud\Exception;

class AbstractResponse
{
    /**
     * @var \StdClass
     */
    protected $response;

    public function __construct($json)
    {
        if (is_object($json)) {
            $this->response = $json;
        } elseif (is_string($json)) {
            $this->response = json_encode($json);
        } else {
            throw new Exception('Unknown Response');
        }
    }

    /**
     * @return \StdClass
     */
    public function getResponse()
    {
        return $this->response;
    }
}