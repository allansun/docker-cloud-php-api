<?php


namespace DockerCloud\API;

use DockerCloud\API\Response\ProviderGetListResponse as GetListResponse;
use DockerCloud\Model\Provider as Model;

class Provider extends AbstractInfrastructrueAPI
{
    protected $api_namespace = '/provider/';

    protected $allowedGetListFilters = [
        'name', //Filter by provider name
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
            ->request('GET', $this->getAPINameSpace()), ['query' => $filters]);
    }


    /**
     * @param $name
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($name)
    {
        return new Model($this->getClient()->request('GET', $this->getAPINameSpace() . $name . '/'));
    }

}