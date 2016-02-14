<?php


namespace DockerCloud\API;

use DockerCloud\Model\NodeType as Model;
use DockerCloud\Model\Response\NodeTypeGetListResponse as GetListResponse;

class NodeType extends AbstractInfrastructrueAPI
{
    protected $api_namespace = '/nodetype/';

    protected $allowedGetListFilters = [
        'name', //Filter by node type name
        'regions', //Filter by resource URI of the target regions
        'availability_zones', //Filter by resource URI of the target availability zones
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
            $this->getAPINameSpace() . $providerName . '/' . $name . '/'
        ));
    }

}