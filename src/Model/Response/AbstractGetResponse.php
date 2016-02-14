<?php


namespace DockerCloud\Model\Response;


abstract class AbstractGetResponse extends AbstractResponse
{
    /**
     * @var MetaData
     */
    protected $meta;

    public function __construct($json)
    {
        parent::__construct($json);

        $this->meta = new MetaData($this->getResponse()->meta);
    }

    /**
     * @return MetaData
     */
    public function getMeta()
    {
        return $this->meta;
    }

}