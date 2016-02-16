<?php
namespace DockerCloud\Model;


use DockerCloud\Model\Common\ModelHydrator;

abstract class AbstractModel
{
    /**
     * AbstractModel constructor.
     *
     * @param \StdClass|array!string $data
     */
    public function __construct($data = null)
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        $this->exchangeArray($data);
    }

    /**
     * @return array
     */
    public function getArrayCopy($fieldsToInclude = [])
    {
        return ModelHydrator::getInstance()->extract($this, $fieldsToInclude);
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

    public function toJson()
    {
        $string= \Zend\Json\Encoder::encode($this->getArrayCopy());
        return preg_replace('/"__className[^,]*,/','',$string);
    }
}