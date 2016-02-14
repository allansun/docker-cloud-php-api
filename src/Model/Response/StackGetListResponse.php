<?php


namespace DockerCloud\Model\Response;


use DockerCloud\Model\Stack as Model;

class StackGetListResponse extends AbstractGetResponse
{
    /**
     * @var Model[]
     */
    protected $objects;

    public function __construct($json)
    {
        parent::__construct($json);

        foreach ((array)$this->getResponse()->objects as $stackData) {
            $this->objects[] = new Model($stackData);
        }
    }

    /**
     * @return Model[]
     */
    public function getObjects()
    {
        return $this->objects;
    }
}