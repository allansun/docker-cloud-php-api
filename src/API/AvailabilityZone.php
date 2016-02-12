<?php


namespace DockerCloud\API;

use DockerCloud\API\Response\AvailabilityZoneGetListResponse as GetListResponse;
use DockerCloud\Model\AvailabilityZone as Model;

class AvailabilityZone extends AbstractInfrastructrueAPI
{
    protected $api_namespace = '/az/';

    protected $allowedGetListFilters = [
        'name', //Filter by availability zone name
        'region', //Filter by resource URI of the target region
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
     * @param $provdiderName
     * @param $regionName
     * @param $name
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($provdiderName, $regionName, $name)
    {
        return new Model($this->getClient()->request('GET',
            $this->getAPINameSpace() . "$provdiderName/$regionName/$name/"
        ));
    }

}