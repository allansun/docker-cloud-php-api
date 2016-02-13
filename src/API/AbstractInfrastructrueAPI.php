<?php


namespace DockerCloud\API;


use DockerCloud\Model\AbstractInfrastructrueModel;

abstract class AbstractInfrastructrueAPI extends AbstractAPI
{
    protected $api_prifix = '/api/infra/v1';

    /**
     * @param $uri
     *
     * @return AbstractInfrastructrueModel
     */
    abstract function getByUri($uri);
}