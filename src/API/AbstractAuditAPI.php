<?php


namespace DockerCloud\API;


use DockerCloud\Model\AbstractAuditModel;

abstract class AbstractAuditAPI extends AbstractAPI
{
    protected $api_prifix = '/api/audit/v1';

    /**
     * @param $uri
     *
     * @return AbstractAuditModel
     */
    abstract function getByUri($uri);
}