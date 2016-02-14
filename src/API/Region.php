<?php


namespace DockerCloud\API;

use DockerCloud\Model\Region as Model;
use DockerCloud\Model\Response\RegionGetListResponse as GetListResponse;

class Region extends AbstractInfrastructrueAPI
{
    protected $api_namespace = '/region/';

    protected $allowedGetListFilters = [
        'name', //Filter by region name
        'provider', //Filter by resource URI of the target provider
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
     * @param $providerName
     * @param $name
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($providerName, $name)
    {
        return new Model($this->getClient()->request('GET',
            $this->getAPINameSpace() . $providerName . '/' . $name . '/'));
    }

}