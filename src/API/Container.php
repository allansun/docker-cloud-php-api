<?php


namespace DockerCloud\API;

use DockerCloud\Model\Container as Model;
use DockerCloud\Model\Response\ContainerGetListResponse as GetListResponse;

class Container extends AbstractApplicationAPI
{
    protected $api_namespace = '/container/';

    protected $allowedGetListFilters = [
        'uuid', //Filter by UUID
        'state', //Filter by state.
        'name', //Filter by container name
        'service', //Filter by resource URI of the target service.
        'node', //Filter by resource URI of the target node.
    ];

    /**
     * @param $uri
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    function getByUri($uri)
    {
        return new Model($this->getClient()->request('GET', $uri));
    }

    /**
     * @param array $filters
     *
     * @return GetListResponse
     * @throws \DockerCloud\Exception
     */
    public function getList($filters = [])
    {
        $this->validateFilter($filters);

        return new GetListResponse($this->getClient()
            ->request('GET', $this->getAPINameSpace(), ['query' => $filters]));
    }


    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($uuid)
    {
        return new Model($this->getClient()->request('GET', $this->getAPINameSpace() . $uuid . '/'));
    }

    /**
     * @param       $uuid
     * @param array $filters
     *
     * @return string
     * @throws \DockerCloud\Exception
     */
    public function logs($uuid, $filters = [])
    {
        $this->validateFilter($filters, [
            'tail', //Number of lines to show from the end of the logs (default: 300)
            'follow', //Whether to stream logs or close the connection immediately (default: true)
            'service', //Filter by service (resource URI)
        ]);

        return $this->getClient()
            ->request('GET', $this->getAPINameSpace() . $uuid . '/logs/', ['query' => $filters], true);
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function start($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/start/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function stop($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/stop/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function redeploy($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/redeploy/'));
    }

    /**
     * @param                    $uuid
     * @param                    $command
     * @param null|bool|\Closure $successCallback
     * @param null|bool|\Closure $failCallback
     *
     * @throws \DockerCloud\Exception
     */
    public function exec($uuid, $command, $successCallback = null, $failCallback = null)
    {
        $this->getClient()
            ->request('GET', $this->getAPINameSpace() . $uuid . '/redeploy/', [
                'query' => [
                    'command' => $command
                ]
            ], $successCallback, $failCallback);
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function terminate($uuid)
    {
        return new Model($this->getClient()->request('DELETE', $this->getAPINameSpace() . $uuid . '/'));
    }
}