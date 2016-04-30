<?php


namespace DockerCloud\API;


use DockerCloud\Model\AbstractInfrastructrueModel;
use DockerCloud\Model\Response\AbstractGetResponse;

abstract class AbstractInfrastructrueAPI extends AbstractAPI
{
    protected $api_prifix = '/api/infra/v1';

    /**
     * @param $uri
     *
     * @return AbstractInfrastructrueModel
     */
    abstract function getByUri($uri);

    /**
     * @param $uri
     *
     * @return AbstractGetResponse
     */
    abstract function getListByUri($uri);
}