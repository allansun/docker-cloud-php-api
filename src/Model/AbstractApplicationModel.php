<?php


namespace DockerCloud\Model;


abstract class AbstractApplicationModel extends AbstractModel
{
    /**
     * @return string
     */
    abstract function getUuid();

    /**
     * @return string
     */
    abstract function getResourceUri();

    /**
     * @return string
     */
    abstract function getState();
}