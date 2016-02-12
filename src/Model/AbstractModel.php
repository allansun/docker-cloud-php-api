<?php
namespace DockerCloud\Model;


use DockerCloud\Model\Common\ModelHydrator;

abstract class AbstractModel
{
    /**
     * AbstractModel constructor.
     *
     * @param \StdClass|array $data
     */
    public function __construct($data = null)
    {
        $this->exchangeArray($data);
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return ModelHydrator::getInstance()->extract($this);
    }

    /**
     * @param $data
     *
     * @return object
     */
    public function exchangeArray($data)
    {
        return ModelHydrator::getInstance()->hydrate((array)$data, $this);
    }
}