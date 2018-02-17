<?php


namespace DockerCloud\API;


abstract class AbstractRepoAPI extends AbstractAPI
{
    protected $api_prifix = '/api/repo/v1';

    public function __construct()
    {
        parent::__construct();

        if($this->getClient()->getNamespace()){
            $this->api_prifix.= '/' . $this->getClient()->getNamespace();
        }
    }
}