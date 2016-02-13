<?php


namespace DockerCloud\API;

use DockerCloud\Exception;

class Event extends AbstractAuditAPI
{
    protected $api_namespace = '/events/';

    /**
     * @param array $filters
     *
     * @return void
     * @throws Exception
     */
    public function getList($filters = [])
    {
        throw new Exception('Method not allowed');
    }


    /**
     * @param $uri
     *
     * @return void
     * @throws Exception
     */
    public function getByUri($uri)
    {
        throw new Exception('Method not allowed');
    }

    /**
     * @param null|bool|\Closure $successCallback
     * @param null|bool|\Closure $failCallback
     *
     * @throws \Exception
     */
    public function listen($successCallback, $failCallback)
    {
        $this->getClient()
            ->request('GET', $this->getAPINameSpace(), [], $successCallback, $failCallback);
    }

}