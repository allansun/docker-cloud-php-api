<?php


namespace DockerCloud\API;

use DockerCloud\API\Response\RegistryGetListResponse as GetListResponse;
use DockerCloud\Model\Registry as Model;

class Registry extends AbstractRepoAPI
{
    protected $api_namespace = '/registry/';

    protected $allowedGetListFilters = [
        'uuid', //Filter by UUID
        'state', //Filter by state.
        'host', //Filter by registry host
        /**
         * Filter by whether the registry is run by Docker or not. Possible values: ‘true’ or 'false’
         */
        'is_docker_registry',
    ];


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
            ->request('GET', $this->getAPINameSpace()), ['query' => $filters]);
    }


    /**
     * @param $host
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($host)
    {
        return new Model($this->getClient()->request('GET',
            $this->getAPINameSpace() . $host . '/'
        ));
    }
}