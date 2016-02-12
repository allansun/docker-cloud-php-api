<?php


namespace DockerCloud\API\Response;


use DockerCloud\Model\Common\ResponseMetaData;

class AbstractGetResponse extends AbstractResponse
{
    /**
     * @var ResponseMetaData
     */
    protected $meta;

    public function __construct($json)
    {
        parent::__construct($json);

        $this->meta = new ResponseMetaData($this->getResponse()->meta);
    }

    /**
     * @return ResponseMetaData
     */
    public function getMeta()
    {
        return $this->meta;
    }

}